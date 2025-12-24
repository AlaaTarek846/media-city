<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use App\Services\ReportTaxiChartsDashboardService;

class DashboardStatisticsController extends Controller
{

    public function index(Request $request)
    {

        $statistics = [];

        // client
        $statistics['clientActiveCount'] = User::where('status',1)->count();
        $statistics['clientDeActiveCount'] = User::where('status',0)->count();
        $statistics['clientCount'] = $statistics['clientActiveCount'] + $statistics['clientDeActiveCount'];

        $statistics['productCount'] = Product::count();
        $statistics['orderCount'] = Order::count();
        $statistics['invoiceRevenue'] = Order::where('order_status_id',2)->sum('total');
        $statistics['setting'] = Setting::with('translation')->first();

        $statistics['invoiceStatisticsMonth'] = Order::where('order_status_id',2)
        ->whereMonth('created_at', now()->month)
        ->selectRaw('DATE(created_at) as day, SUM(total) as total_amount')
        ->groupBy('day')
        ->orderBy('day')
        ->get();


        //booking
        $statistics['processing'] = Order::where('order_status_id',1)->count();
        $statistics['delivered'] = Order::where('order_status_id',2)->count();
        $statistics['canceled'] = Order::where('order_status_id',3)->count();
        $statistics['total_booking'] = $statistics['processing'] + $statistics['delivered'] + $statistics['canceled'];





        $statistics['top_five_users_has_orders'] =
        User::select('id','name','phone')->withCount(['orders'])->orderByDesc('orders_count')->take(5)->get()->map(function($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'phone' => $item->phone,
                'orders_count' => $item->orders_count,
            ];
        });


        $statistics['top_five_products_has_orders'] =
        Product::select('id','image')->withCount(['orderItems'])->orderByDesc('order_items_count')->take(5)->get()->map(function($item) {
            return [
                'id' => $item->id,
                'name' => $item->current_translation->title,
                'image' => $item->image,
                'order_items_count' => $item->order_items_count,
            ];
        });

        return responseJson($statistics,
            'Dashboard Statistics',
            200
        );

    }


}
