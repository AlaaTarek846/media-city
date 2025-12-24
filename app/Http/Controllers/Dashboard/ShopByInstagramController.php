<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ShopByInstagramRequest;
use App\Http\Resources\Dashboard\ShopByInstagramResource;
use App\Models\ShopByInstagram;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class ShopByInstagramController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:shop by instagram read', only: ['index']),
            new Middleware('can:shop by instagram create', only: ['store']),
            new Middleware('can:shop by instagram edit', only: ['update', 'show']),
            new Middleware('can:shop by instagram delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $instagram = ShopByInstagram::searchAndFilter()->latest()->paginate(10);

        return responseJson(ShopByInstagramResource::collection($instagram->items()),'',200,getPaginates($instagram));
    }



    public function store(ShopByInstagramRequest $request)
    {
        $data = $request->validated();
        $data['image'] = store_single_image($request->image);
        ShopByInstagram::create($data);
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $instagram = ShopByInstagram::find($id);
        return responseJson($instagram,'Data exited successfully',200);
    }

    public function update(ShopByInstagramRequest $request, $id)
    {
        $instagram = ShopByInstagram::find($id);
        $data = $request->validated();
        if($request->hasFile('image')){
            unlink_image_by_path($instagram->getAttributes()['image']);
            $data['image'] = store_single_image($request->image);
        }
        $instagram->update($data);
        return responseJson($instagram,'Updated Successfully',200);
    }

    public function destroy($id)
    {
        $instagram = ShopByInstagram::find($id);
        if (!$instagram) {
            return responseJson([],'Data not found',404);
        }
        unlink_image_by_path($instagram->getAttributes()['image']);
        $instagram->delete();
        return responseJson([],'Deleted Successfully',200);
    }
}
