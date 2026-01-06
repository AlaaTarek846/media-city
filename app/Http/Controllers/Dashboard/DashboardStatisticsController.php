<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use App\Services\ReportTaxiChartsDashboardService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardStatisticsController extends Controller
{

    public function index(Request $request)
    {
        try {
            $statistics = [];

            // client
            $statistics['clientActiveCount'] = User::where('status',1)->count();
            $statistics['clientDeActiveCount'] = User::where('status',0)->count();
            $statistics['clientCount'] = $statistics['clientActiveCount'] + $statistics['clientDeActiveCount'];

            $statistics['productCount'] = Product::count();
            $statistics['orderCount'] = Order::count();
            // Invoice revenue (تم التسليم - order_status_id = 4)
            $statistics['invoiceRevenue'] = Order::where('order_status_id', 4)->sum('total') ?? 0;
            $statistics['setting'] = Setting::with('translation')->first();

            // Invoice statistics (completed orders only - order_status_id = 4 تم التسليم)
            $statistics['invoiceStatisticsMonth'] = Order::where('order_status_id', 4)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->selectRaw('DATE(created_at) as day, SUM(total) as total_amount, COUNT(*) as count')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

            // Orders statistics (all orders regardless of status)
            $statistics['orderStatisticsMonth'] = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->selectRaw('DATE(created_at) as day, SUM(total) as total_amount, COUNT(*) as count')
            ->groupBy('day')
            ->orderBy('day')
            ->get();


            //booking statistics
            // معلق = order_status_id في [1, 2, 3]
            $statistics['processing'] = Order::whereIn('order_status_id', [1, 2, 3])->count() ?? 0;
            // تم التسليم = order_status_id = 4
            $statistics['delivered'] = Order::where('order_status_id', 4)->count() ?? 0;
            // تم الإلغاء = order_status_id = 5
            $statistics['canceled'] = Order::where('order_status_id', 5)->count() ?? 0;
            $statistics['total_booking'] = ($statistics['processing'] ?? 0) + ($statistics['delivered'] ?? 0) + ($statistics['canceled'] ?? 0);

            $statistics['top_five_users_has_orders'] =
            User::select('id','name','mobile')->withCount(['orders'])->orderByDesc('orders_count')->take(5)->get()->map(function($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name ?? '',
                    'phone' => $item->mobile ?? '',
                    'orders_count' => $item->orders_count ?? 0,
                ];
            });

            $statistics['top_five_products_has_orders'] =
            Product::select('id','image')->withCount(['orderItems'])->orderByDesc('order_items_count')->take(5)->get()->map(function($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->current_translation?->title ?? '',
                    'image' => $item->image ?? '',
                    'order_items_count' => $item->order_items_count ?? 0,
                ];
            });

            return responseJson($statistics,
                'Dashboard Statistics',
                200
            );
        } catch (\Exception $e) {
            \Log::error('Dashboard Statistics Error: ' . $e->getMessage());
            return responseJson([], 
                'Error loading statistics: ' . $e->getMessage(), 
                500
            );
        }
    }

    /**
     * Get total revenue per months (current and last month divided by weeks)
     */
    public function getTotalRevenuePerMonths(Request $request)
    {
        $now = now();
        $currentMonth = $now->month;
        $currentYear = $now->year;
        $lastMonthDate = $now->copy()->subMonth();
        $lastMonth = $lastMonthDate->month;
        $lastYear = $lastMonthDate->year;

        // Current month orders grouped by weeks (تم التسليم - order_status_id = 4)
        $currentMonthOrders = Order::where('order_status_id', 4)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->selectRaw('DAY(created_at) as day, SUM(total) as total_amount, COUNT(*) as count')
            ->groupBy('day')
            ->get()
            ->map(function ($item) {
                $day = (int) $item->day;
                $weekNumber = ceil($day / 7);
                $weekName = $this->getWeekName($weekNumber);
                return [
                    'week' => $weekName,
                    'number' => $item->count,
                    'amount' => $item->total_amount,
                ];
            })
            ->groupBy('week')
            ->map(function ($group, $week) {
                return [
                    'week' => $week,
                    'number' => $group->sum('number'),
                    'amount' => $group->sum('amount'),
                ];
            })
            ->values();

        // Last month orders grouped by weeks (تم التسليم - order_status_id = 4)
        $lastMonthOrders = Order::where('order_status_id', 4)
            ->whereYear('created_at', $lastYear)
            ->whereMonth('created_at', $lastMonth)
            ->selectRaw('DAY(created_at) as day, SUM(total) as total_amount, COUNT(*) as count')
            ->groupBy('day')
            ->get()
            ->map(function ($item) {
                $day = (int) $item->day;
                $weekNumber = ceil($day / 7);
                $weekName = $this->getWeekName($weekNumber);
                return [
                    'week' => $weekName,
                    'number' => $item->count,
                    'amount' => $item->total_amount,
                ];
            })
            ->groupBy('week')
            ->map(function ($group, $week) {
                return [
                    'week' => $week,
                    'number' => $group->sum('number'),
                    'amount' => $group->sum('amount'),
                ];
            })
            ->values();

        return responseJson([
            'current_month' => $currentMonthOrders,
            'last_month' => $lastMonthOrders,
        ], 'Revenue per months', 200);
    }

    /**
     * Get total revenue and count for each month in the year
     */
    public function getTotalRevenueForEachYearPerMonths(Request $request)
    {
        $year = $request->get('year', now()->year);

        // Total amount by month (تم التسليم - order_status_id = 4)
        $totalAmountByMonth = Order::where('order_status_id', 4)
            ->whereYear('created_at', $year)
            ->selectRaw("DATE_FORMAT(created_at, '%M') as month, SUM(total) as total_amount")
            ->groupBy('month')
            ->orderByRaw("MONTH(STR_TO_DATE(month, '%M'))")
            ->get();

        // Total count by month (تم التسليم - order_status_id = 4)
        $totalCountByMonth = Order::where('order_status_id', 4)
            ->whereYear('created_at', $year)
            ->selectRaw("DATE_FORMAT(created_at, '%M') as month, COUNT(*) as total_count")
            ->groupBy('month')
            ->orderByRaw("MONTH(STR_TO_DATE(month, '%M'))")
            ->get();

        return responseJson([
            'total_amount_for_each_month_in_year' => $totalAmountByMonth,
            'total_count_for_each_month_in_year' => $totalCountByMonth,
        ], 'Total revenue and count for each month', 200);
    }

    /**
     * Get peak periods (orders grouped by time periods)
     */
    public function getPeakPeriods(Request $request)
    {
        $periods = [
            '00:00-06:00' => ['00:00', '06:00'],
            '06:00-12:00' => ['06:00', '12:00'],
            '12:00-18:00' => ['12:00', '18:00'],
            '18:00-24:00' => ['18:00', '24:00'],
        ];

        $peakPeriods = [];

        foreach ($periods as $periodName => $times) {
            // Peak periods (تم التسليم - order_status_id = 4)
            $count = Order::where('order_status_id', 4)
                ->whereRaw("TIME(created_at) >= ? AND TIME(created_at) < ?", [$times[0], $times[1]])
                ->count();

            $peakPeriods[] = [
                'period' => $periodName,
                'count' => $count,
            ];
        }

        return responseJson([
            'peak_periods' => $peakPeriods,
        ], 'Peak periods', 200);
    }

    /**
     * Helper function to get week name
     */
    private function getWeekName($weekNumber)
    {
        $weeks = [
            1 => 'First Week',
            2 => 'Second Week',
            3 => 'Third Week',
            4 => 'Fourth Week',
            5 => 'Fifth Week',
        ];

        return $weeks[$weekNumber] ?? 'First Week';
    }

}
