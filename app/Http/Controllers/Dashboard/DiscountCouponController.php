<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\DiscountCouponRequest;
use App\Http\Resources\Dashboard\DiscountCouponResource;
use App\Models\DiscountCoupon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DiscountCouponController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:discount coupon read', only: ['index']),
            new Middleware('can:discount coupon create', only: ['store']),
            new Middleware('can:discount coupon edit', only: ['update', 'show']),
            new Middleware('can:discount coupon delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $coupons = DiscountCoupon::searchAndFilter()->latest()->paginate(10);

        return responseJson(DiscountCouponResource::collection($coupons->items()),'',200,getPaginates($coupons));
    }



    public function store(DiscountCouponRequest $request)
    {
        $data = $request->validated();
        $coupon = DiscountCoupon::create($data);
        $coupon->setTranslations($request->translations);
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $coupon = DiscountCoupon::with('translations')->find($id);
        return responseJson($coupon,'Data exited successfully',200);
    }

    public function update(DiscountCouponRequest $request,$id)
    {
        $data = $request->validated();
        $coupon = DiscountCoupon::find($id);
        $coupon->update($data);
        $coupon->setTranslations($request->translations);
        return responseJson($coupon,'Updated Successfully',200);
    }

    public function destroy($id)
    {
        $coupon = DiscountCoupon::find($id);
        $coupon->delete();
        return responseJson([],'Deleted Successfully',200);
    }
    
}
