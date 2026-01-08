<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\HeaderOfferRequest;
use App\Http\Resources\Dashboard\HeaderOfferResource;
use App\Models\HeaderOffer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class HeaderOfferController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:headerOffer read', only: ['index']),
            new Middleware('can:headerOffer create', only: ['store']),
            new Middleware('can:headerOffer edit', only: ['update', 'show']),
            new Middleware('can:headerOffer delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $headerOffers = HeaderOffer::with('translations')->searchAndFilter()->latest()->paginate(10);

        return responseJson(HeaderOfferResource::collection($headerOffers->items()),'',200,getPaginates($headerOffers));
    }



    public function store(HeaderOfferRequest $request)
    {

        $data = $request->validated();
        $headerOffer = HeaderOffer::create($data);
        $headerOffer->setTranslations($request->translations);
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $headerOffer = HeaderOffer::with('translations')->find($id);
        return responseJson($headerOffer,'Data exited successfully',200);
    }

    public function update(HeaderOfferRequest $request, HeaderOffer $headerOffer)
    {
        $data = $request->validated();
        $headerOffer->update($data);
        $headerOffer->setTranslations($request->translations);
        return responseJson($headerOffer,'Updated Successfully',200);
    }

    public function destroy(HeaderOffer $headerOffer)
    {
        $headerOffer->delete();
        return responseJson([],'Deleted Successfully',200);
    }


}
