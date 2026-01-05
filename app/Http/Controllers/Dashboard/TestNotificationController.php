<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Events\ContactMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TestNotificationController extends Controller
{
    /**
     * Test complete notification flow
     */
    public function testCompleteFlow(Request $request)
    {
        $results = [];
        
        // 1. Check if contact_messages table exists and has data
        try {
            $count = ContactMessage::count();
            $latest = ContactMessage::latest()->first();
            $results['database'] = [
                'status' => 'success',
                'total_messages' => $count,
                'latest_message' => $latest ? [
                    'id' => $latest->id,
                    'name' => $latest->name,
                    'email' => $latest->email,
                    'subject' => $latest->subject,
                    'is_read' => $latest->is_read ?? false,
                    'created_at' => $latest->created_at->format('Y-m-d H:i:s'),
                ] : null
            ];
        } catch (\Exception $e) {
            $results['database'] = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

        // 2. Check if columns exist
        try {
            $columns = DB::select("SHOW COLUMNS FROM contact_messages");
            $columnNames = array_column($columns, 'Field');
            $results['columns'] = [
                'status' => 'success',
                'columns' => $columnNames,
                'has_is_read' => in_array('is_read', $columnNames),
                'has_read_at' => in_array('read_at', $columnNames),
            ];
        } catch (\Exception $e) {
            $results['columns'] = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

        // 3. Test creating a new message
        try {
            $testMessage = ContactMessage::create([
                'name' => 'Test User ' . now()->format('H:i:s'),
                'email' => 'test' . time() . '@example.com',
                'phone' => '01234567890',
                'subject' => 'Test Notification - ' . now()->format('Y-m-d H:i:s'),
                'message' => 'This is a test message to verify the notification system.',
                'is_read' => false,
            ]);

            $results['create_message'] = [
                'status' => 'success',
                'message_id' => $testMessage->id,
                'data' => [
                    'id' => $testMessage->id,
                    'name' => $testMessage->name,
                    'email' => $testMessage->email,
                    'subject' => $testMessage->subject,
                    'is_read' => $testMessage->is_read,
                    'created_at' => $testMessage->created_at->format('Y-m-d H:i:s'),
                ]
            ];
        } catch (\Exception $e) {
            $results['create_message'] = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

        // 4. Test broadcasting event
        try {
            if (isset($testMessage)) {
                event(new ContactMessageNotification($testMessage));
                Log::info('ContactMessageNotification event dispatched', [
                    'message_id' => $testMessage->id
                ]);
                
                $results['broadcast'] = [
                    'status' => 'success',
                    'message' => 'Event dispatched successfully',
                    'channel' => 'private-admin.notifications',
                    'event' => 'contact-message.created',
                    'message_id' => $testMessage->id
                ];
            } else {
                $results['broadcast'] = [
                    'status' => 'skipped',
                    'message' => 'Message creation failed, skipping broadcast'
                ];
            }
        } catch (\Exception $e) {
            $results['broadcast'] = [
                'status' => 'error',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ];
        }

        // 5. Test API endpoints
        try {
            $unreadCount = ContactMessage::where('is_read', false)->count();
            $recentMessages = ContactMessage::latest()->limit(5)->get()->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'name' => $msg->name,
                    'email' => $msg->email,
                    'subject' => $msg->subject,
                    'is_read' => $msg->is_read ?? false,
                    'created_at' => $msg->created_at->format('Y-m-d H:i:s'),
                ];
            });

            $results['api'] = [
                'status' => 'success',
                'unread_count' => $unreadCount,
                'recent_messages' => $recentMessages
            ];
        } catch (\Exception $e) {
            $results['api'] = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

        // 6. Check broadcasting configuration
        $results['config'] = [
            'broadcast_driver' => config('broadcasting.default'),
            'pusher_app_id' => config('broadcasting.connections.pusher.app_id'),
            'pusher_key' => config('broadcasting.connections.pusher.key'),
            'pusher_cluster' => config('broadcasting.connections.pusher.options.cluster'),
        ];

        return responseJson([
            'test_results' => $results,
            'summary' => [
                'database_check' => $results['database']['status'] ?? 'unknown',
                'columns_check' => $results['columns']['status'] ?? 'unknown',
                'create_message' => $results['create_message']['status'] ?? 'unknown',
                'broadcast_event' => $results['broadcast']['status'] ?? 'unknown',
                'api_endpoints' => $results['api']['status'] ?? 'unknown',
            ]
        ], 'Test completed', 200);
    }

    /**
     * Get all contact messages for testing
     */
    public function getAllMessages()
    {
        try {
            $messages = ContactMessage::latest()->get()->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'name' => $msg->name,
                    'email' => $msg->email,
                    'phone' => $msg->phone,
                    'subject' => $msg->subject,
                    'message' => $msg->message,
                    'is_read' => $msg->is_read ?? false,
                    'read_at' => $msg->read_at ? $msg->read_at->format('Y-m-d H:i:s') : null,
                    'created_at' => $msg->created_at->format('Y-m-d H:i:s'),
                ];
            });

            return responseJson([
                'data' => $messages,
                'total' => $messages->count(),
                'unread' => ContactMessage::where('is_read', false)->count(),
            ], 'Messages retrieved successfully', 200);
        } catch (\Exception $e) {
            return responseJson([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 'Error retrieving messages', 500);
        }
    }

    /**
     * Test event dispatch directly
     */
    public function testEventDispatch(Request $request)
    {
        try {
            $messageId = $request->input('message_id');
            
            if (!$messageId) {
                // Create a new test message
                $message = ContactMessage::create([
                    'name' => 'Test Event ' . now()->format('H:i:s'),
                    'email' => 'event' . time() . '@test.com',
                    'phone' => '01234567890',
                    'subject' => 'Test Event Dispatch - ' . now()->format('Y-m-d H:i:s'),
                    'message' => 'Testing event dispatch directly',
                    'is_read' => false,
                ]);
            } else {
                $message = ContactMessage::findOrFail($messageId);
            }

            // Dispatch event
            event(new ContactMessageNotification($message));

            return responseJson([
                'status' => 'success',
                'message' => 'Event dispatched successfully',
                'data' => [
                    'message_id' => $message->id,
                    'channel' => 'private-admin.notifications',
                    'event' => 'contact-message.created',
                    'broadcast_data' => [
                        'id' => $message->id,
                        'name' => $message->name,
                        'email' => $message->email,
                        'subject' => $message->subject,
                        'message' => $message->message,
                        'created_at' => $message->created_at->format('Y-m-d H:i:s'),
                        'is_read' => $message->is_read ?? false,
                    ]
                ]
            ], 'Event dispatched', 200);
        } catch (\Exception $e) {
            return responseJson([
                'status' => 'error',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 'Error dispatching event', 500);
        }
    }
}




