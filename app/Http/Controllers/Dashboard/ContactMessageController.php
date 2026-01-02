<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\ContactMessageResource;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ContactMessageController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        // return [];
        return [
            new Middleware('can:contact message read', only: ['index']),
        ];
    }

    public function index(Request $request)
    {
        $query = ContactMessage::searchAndFilter();
        
        // Filter by read status
        if ($request->has('filter')) {
            if ($request->filter === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->filter === 'read') {
                $query->where('is_read', true);
            }
        }
        
        $ContactMessage = $query->latest()->paginate(10);

        return responseJson(ContactMessageResource::collection($ContactMessage->items()), 'ContactMessage', 200, getPaginates($ContactMessage));
    }
    
    /**
     * Mark message as read
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
        return responseJson(new ContactMessageResource($message), 'Message marked as read', 200);
    }

}
