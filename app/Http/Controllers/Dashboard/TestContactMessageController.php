<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Events\ContactMessageNotification;
use Illuminate\Http\Request;

class TestContactMessageController extends Controller
{
    /**
     * Test sending a contact message and broadcasting
     */
    public function testContactMessage(Request $request)
    {
        // Create a test contact message
        $contactMessage = ContactMessage::create([
            'name' => $request->input('name', 'Test User ' . now()->format('H:i:s')),
            'email' => $request->input('email', 'test@example.com'),
            'phone' => $request->input('phone', '01234567890'),
            'subject' => $request->input('subject', 'Test Message - ' . now()->format('Y-m-d H:i:s')),
            'message' => $request->input('message', 'This is a test message to verify Pusher broadcasting.'),
            'is_read' => false,
        ]);

        // Broadcast the notification event
        event(new ContactMessageNotification($contactMessage));

        return responseJson([
            'data' => [
                'id' => $contactMessage->id,
                'name' => $contactMessage->name,
                'email' => $contactMessage->email,
                'subject' => $contactMessage->subject,
                'message' => $contactMessage->message,
                'created_at' => $contactMessage->created_at->format('Y-m-d H:i:s'),
            ],
            'broadcast' => [
                'channel' => 'private-admin.notifications',
                'event' => 'contact-message.created',
                'status' => 'sent'
            ]
        ], 'Test message created and broadcasted successfully', 200);
    }
}


