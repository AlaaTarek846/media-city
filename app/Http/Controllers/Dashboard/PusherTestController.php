<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

class PusherTestController extends Controller
{
    /**
     * Test Pusher connection - Send a test event
     */
    public function testPusher(Request $request)
    {
        // Send test event to public channel
        event(new \App\Events\PusherTestEvent($request->input('message', 'Test message from Laravel')));

        return responseJson([
            'message' => 'Test event sent successfully',
            'channel' => 'test-channel',
            'event' => 'pusher-test'
        ], 'Test event sent', 200);
    }

    /**
     * Test private channel (admin.notifications)
     */
    public function testPrivateChannel(Request $request)
    {
        // This will use the existing admin.notifications channel
        event(new \App\Events\PusherTestEvent($request->input('message', 'Test private message'), true));

        return responseJson([
            'message' => 'Test private event sent successfully',
            'channel' => 'private-admin.notifications',
            'event' => 'pusher-test'
        ], 'Test private event sent', 200);
    }
}

