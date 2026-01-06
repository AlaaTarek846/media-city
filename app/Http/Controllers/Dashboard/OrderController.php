<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\OrderResource;
use App\Http\Resources\Dashboard\OrderShowResource;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OrderController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        // return [];
        return [
            new Middleware('can:order read', only: ['index']),
            new Middleware('can:order edit', only: ['update']),
        ];
    }

    public function index(Request $request)
    {
        $query = Order::searchAndFilter();

        // Filter by read status (all, unread, or read)
        if ($request->has('filter')) {
            if ($request->filter === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->filter === 'read') {
                $query->where('is_read', true);
            }
        }

        // Filter by date (today, yesterday, or all)
        if ($request->has('date_filter') && $request->date_filter) {
            // Use DATE() function to extract date part and compare
            $query->whereRaw("DATE(created_at) = ?", [$request->date_filter]);
        }

        // Search by specific date
        if ($request->has('date_search') && $request->date_search) {
            // Use DATE() function to extract date part and compare
            $query->whereRaw("DATE(created_at) = ?", [$request->date_search]);
        }

        // Filter by order status IDs (multiple)
        if ($request->has('order_status_ids') && $request->order_status_ids) {
            $statusIds = explode(',', $request->order_status_ids);
            $statusIds = array_filter($statusIds, function($id) {
                return !empty($id) && is_numeric($id);
            });
            if (!empty($statusIds)) {
                $query->whereIn('order_status_id', $statusIds);
            }
        }

        $orders = $query->latest()->paginate(10);

        return responseJson(OrderResource::collection($orders->items()), 'ContactMessage', 200, getPaginates($orders));
    }

    public function show($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return responseJson('Order not found', 'error', 404);
        }
        $setting = Setting::with('translation')->first();
        return responseJson(['order'=>new OrderShowResource($order),'setting' => $setting], 'Order', 200);
    }

    public function update(Request $request,$id){
        $order = Order::find($id);

        if ($request->order_status_id == 5){
            if ($order->order_status_id != 5){
                foreach ($order->orderItems as $cartItem) {
                    $cartItem->productVariant->increment('quantity', $cartItem->quantity);
                }
            }

        }else{
            if ($order->order_status_id == 5){
                foreach ($order->orderItems as $cartItem) {
                    $cartItem->productVariant->decrement('quantity', $cartItem->quantity);
                }
            }
        }


        $order->update([
            'order_status_id' => $request->order_status_id,
        ]);

        return responseJson([],'Updated Successfully',200);
    }

    public function orderStatus()
    {
        $orderStatuses = OrderStatus::all()
            ->map(function ($status) {
                return [
                    'id'    => $status->id,
                    'title' => $status->current_translation?->title,
                ];
            });

        return responseJson($orderStatuses, 'Order Statuses', 200);
    }

    /**
     * Mark an order as read
     */
    public function markAsRead($id)
    {
        $order = Order::findOrFail($id);

        if (!$order->is_read) {
            $order->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        return responseJson([
            'data' => new OrderResource($order),
        ], 'Order marked as read', 200);
    }

    /**
     * Get unread orders count
     */
    public function getUnreadCount()
    {
        $count = Order::where('is_read', false)->count();

        return responseJson([
            'count' => $count,
        ], '', 200);
    }

}
