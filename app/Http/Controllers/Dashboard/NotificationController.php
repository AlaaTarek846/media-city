<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\NotificationResource;
use App\Http\Resources\Dashboard\ContactMessageResource;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function getAllNot(Request $request)
    {
        $count = 15;
        $skip = 0;

        if($request->skip){
            $skip = $request->skip;
        }

        $Notifications = auth()->guard('admin_api')->user()->notifications()->latest()->skip($skip)->limit($count)->get();
        $NotificationsCount = auth()->guard('admin_api')->user()->notifications->count();

        return responseJson(['notifications' => NotificationResource::collection($Notifications),'count' => $NotificationsCount],'',200);

    }

    public function getNotNotRead()
    {
        $user = auth()->guard('admin_api')->user();
        $Notifications = $user->unreadNotifications;
        $NotificationsCount = $Notifications->count();
        return responseJson(['notifications' => NotificationResource::collection($Notifications),'count' => $NotificationsCount],'',200);

    }

    public function clearItem($id)
    {

        auth()->guard('admin_api')->user()->notifications()->where('id', $id)->update(['read_at' => now()]);

        return responseJson([],'Data exited successfully',200);
    }

    public function clearAll()
    {
        $user = auth()->guard('admin_api')->user();
        $user->unreadNotifications()->update(['read_at' => now()]);
        return responseJson([],'Data exited successfully',200);
    }

    /**
     * Get contact messages (with optional filter)
     */
    public function getContactMessages(Request $request)
    {
        $query = ContactMessage::query();

        // Filter by read status
        if ($request->has('filter')) {
            if ($request->filter === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->filter === 'read') {
                $query->where('is_read', true);
            }
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $messages = $query->latest()->paginate($perPage);

        return responseJson([
            'data' => ContactMessageResource::collection($messages->items()),
            'current_page' => $messages->currentPage(),
            'last_page' => $messages->lastPage(),
            'per_page' => $messages->perPage(),
            'total' => $messages->total(),
        ], '', 200);
    }

    /**
     * Mark a contact message as read
     */
    public function markAsRead($id)
    {
        $message = ContactMessage::findOrFail($id);
        
        if (!$message->is_read) {
            $message->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        return responseJson([
            'data' => new ContactMessageResource($message),
        ], 'Message marked as read', 200);
    }

    /**
     * Get unread contact messages count
     */
    public function getUnreadCount()
    {
        $count = ContactMessage::where('is_read', false)->count();

        return responseJson([
            'count' => $count,
        ], '', 200);
    }

}
