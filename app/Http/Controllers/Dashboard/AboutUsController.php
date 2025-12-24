<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AboutUsRequest;
use App\Http\Resources\Dashboard\AboutUsResource;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AboutUsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        // return [];
        return [
            new Middleware('can:about us read', only: ['index']),
            new Middleware('can:about us edit',only:['update']),
        ];
    }
    public function index(Request $request)
    {
        $AboutUs = AboutUs::searchAndFilter()->latest()->paginate(10);

        return responseJson(AboutUsResource::collection($AboutUs->items()), 'AboutUs', 200, getPaginates($AboutUs));
    }

    public function show($id)
    {
        $AboutUs = AboutUs::with('translations')->findOrFail($id);
        return responseJson($AboutUs, 'Updated Successfully', 200);
    }

    public function update(AboutUsRequest $request,$id){
        $AboutUs = AboutUs::find($id);
        if($request->hasFile('image')){
            unlink_image_by_path($AboutUs->getAttributes()['image']);
            $data['image'] = store_single_image($request->image);
        }
        $AboutUs->update($data);
        $AboutUs->setTranslations($request->translations);
        return responseJson(new AboutUsResource($AboutUs),'Updated Successfully', 200);
    }

}
