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
        $orders = Order::searchAndFilter()->latest()->paginate(10);

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
        $order->update([
            'order_status_id' => $request->order_status_id,
        ]);

        return responseJson([],'Updated Successfully',200);
    }

    public function orderStatus()
    {
        $orderStatuses = OrderStatus::all()->map(function ($status) {
            return [
            'id' => $status->id,
            'title' => $status->current_translation?->title,
            ];
        });
        return responseJson($orderStatuses, 'Order Statuses', 200);
    }

}
