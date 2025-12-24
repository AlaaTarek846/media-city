<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\TestimonialRequest;
use App\Http\Resources\Dashboard\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TestimonialController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:testimonial read', only: ['index']),
            new Middleware('can:testimonial create', only: ['store']),
            new Middleware('can:testimonial edit', only: ['update', 'show']),
            new Middleware('can:testimonial delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $testimonial = Testimonial::searchAndFilter()->latest()->paginate(10);

        return responseJson(TestimonialResource::collection($testimonial->items()),'',200,getPaginates($testimonial));
    }



    public function store(TestimonialRequest $request)
    {

        $data = $request->validated();
        $data['image'] = store_single_image($request->image);
        $testimonial = Testimonial::create($data);
        $testimonial->setTranslations($request->translations);
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $testimonial = Testimonial::with('translations')->find($id);
        return responseJson($testimonial,'Data exited successfully',200);
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial)
    {
        $data = $request->validated();
        if($request->hasFile('image')){
            unlink_image_by_path($testimonial->getAttributes()['image']);
            $data['image'] = store_single_image($request->image);
        }
        $testimonial->update($data);
        $testimonial->setTranslations($request->translations);
        return responseJson($testimonial,'Updated Successfully',200);
    }

    public function destroy(Testimonial $testimonial)
    {
        unlink_image_by_path($testimonial->getAttributes()['image']);
        $testimonial->delete();
        return responseJson([],'Deleted Successfully',200);
    }
}
