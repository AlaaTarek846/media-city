<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\BannerRequest;
use App\Http\Requests\Dashboard\SliderRequest;
use App\Http\Resources\Dashboard\BannerResource;
use App\Http\Resources\Dashboard\SliderResource;
use App\Models\Banner;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class SliderController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:slider read', only: ['index']),
            new Middleware('can:slider create', only: ['store']),
            new Middleware('can:slider edit', only: ['update', 'show']),
            new Middleware('can:slider delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $sliders = Slider::searchAndFilter()->latest()->paginate(10);

        return responseJson(SliderResource::collection($sliders->items()),'',200,getPaginates($sliders));
    }



    public function store(SliderRequest $request)
    {
        $data = $request->validated();
        $data['image'] = store_single_image($request->image);
        $slider=Slider::create($data);
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $slider=Slider::find($id);
        return responseJson($slider,'Data exited successfully',200);
    }

    public function update(SliderRequest $request, Slider $slider)
    {
        $data = $request->validated();
        if($request->hasFile('image')){
            unlink_image_by_path($slider->getAttributes()['image']);
            $data['image'] = store_single_image($request->image);
        }
        $slider->update($data);
        return responseJson($slider,'Updated Successfully',200);
    }

    public function destroy(Slider $slider)
    {
        unlink_image_by_path($slider->getAttributes()['image']);
        $slider->delete();
        return responseJson([],'Deleted Successfully',200);
    }
}
