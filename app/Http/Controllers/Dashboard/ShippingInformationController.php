<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\PolicyRequest;
use App\Models\ShippingInformation;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ShippingInformationController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        // return [];
        return [
            new Middleware('can:shipping information read', only: ['index']),
            new Middleware('can:shipping information edit',only:['update']),
        ];
    }

    public function show($id)
    {
        $JoinUs = ShippingInformation::with('translations')->findOrFail($id);
        return responseJson($JoinUs, 'Updated Successfully', 200);
    }

    public function update(PolicyRequest $request,$id){
        $data =$request->validated();
        $joinUs = ShippingInformation::find($id);
        $joinUs->update($data);
        return responseJson($joinUs,'Updated Successfully', 200);
    }
}
