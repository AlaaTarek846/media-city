<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\BrandRequest;
use App\Http\Resources\Dashboard\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BrandController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:brand read', only: ['index']),
            new Middleware('can:brand create', only: ['store']),
            new Middleware('can:brand edit', only: ['update', 'show']),
            new Middleware('can:brand delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $brand = Brand::searchAndFilter()->latest()->paginate(10);

        return responseJson(BrandResource::collection($brand->items()),'',200,getPaginates($brand));
    }



    public function store(BrandRequest $request)
    {

        $data = $request->validated();
        $data['image'] = store_single_image($request->image);
        $brand = Brand::create($data);
        $brand->setTranslations($request->translations);
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $brand = Brand::with('translations')->find($id);
        return responseJson($brand,'Data exited successfully',200);
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        $data = $request->validated();
        if($request->hasFile('image')){
            unlink_image_by_path($brand->getAttributes()['image']);
            $data['image'] = store_single_image($request->image);
        }
        $brand->update($data);
        $brand->setTranslations($request->translations);
        return responseJson($brand,'Updated Successfully',200);
    }

    public function destroy(Brand $brand)
    {
        unlink_image_by_path($brand->getAttributes()['image']);
        $brand->delete();
        return responseJson([],'Deleted Successfully',200);
    }

     public function dropdown()
    {
        $brands = Brand::select('id')
            ->with(['translations' => function($query) {
                $query->where('locale', app()->getLocale());
            }])
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'title' => $category->translations->pluck('title')->first() ?: '',
                ];
            });

        return responseJson($brands,'',200);
    }
}
