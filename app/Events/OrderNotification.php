<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    /**
     * Create a new event instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('admin.notifications'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'order.created';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        // Load relationships if not already loaded
        if (!$this->order->relationLoaded('user')) {
            $this->order->load('user');
        }
        if (!$this->order->relationLoaded('orderStatus')) {
            $this->order->load('orderStatus.translations');
        }

        return [
            'id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'user_name' => $this->order->user?->name,
            'user_phone' => $this->order->user?->mobile ?? $this->order->user?->phone,
            'user_email' => $this->order->user?->email,
            'total' => $this->order->total,
            'order_status' => $this->order->orderStatus?->current_translation?->title,
            'created_at' => $this->order->created_at->format('Y-m-d H:i:s'),
        ];
    }
}

