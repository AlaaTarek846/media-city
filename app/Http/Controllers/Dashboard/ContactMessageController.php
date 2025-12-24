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
        $ContactMessage = ContactMessage::searchAndFilter()->latest()->paginate(10);

        return responseJson(ContactMessageResource::collection($ContactMessage->items()), 'ContactMessage', 200, getPaginates($ContactMessage));
    }

}
