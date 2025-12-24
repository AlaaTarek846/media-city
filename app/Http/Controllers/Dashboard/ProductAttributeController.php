<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProductAttributeRequest;
use App\Http\Resources\Dashboard\ProductAttributeResource;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductAttributeController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:product attribute read', only: ['index']),
            new Middleware('can:product attribute create', only: ['store']),
            new Middleware('can:product attribute edit', only: ['update', 'show']),
            new Middleware('can:product attribute delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $variants = ProductAttribute::searchAndFilter()->latest()->paginate(10);

        return responseJson(ProductAttributeResource::collection($variants->items()),'',200,getPaginates($variants));
    }

    public function store(ProductAttributeRequest $request)
    {
        $data = $request->validated();
        $variant = ProductAttribute::create($data);
        $variant->setTranslations($request->translations);
        return responseJson([],'Created Successfully',200);
    }

    public function show($id)
    {
        $variant = ProductAttribute::with('translations')->find($id);
        return responseJson($variant,'Data exited successfully',200);
    }

    public function update(ProductAttributeRequest $request,$id)
    {
        $data = $request->validated();
        $variant = ProductAttribute::find($id);
        $variant->update($data);
        $variant->setTranslations($request->translations);
        return responseJson($variant,'Updated Successfully',200);
    }

    public function destroy($id)
    {
        $variant = ProductAttribute::find($id);
        $variant->delete();
        return responseJson([],'Deleted Successfully',200);
    }

    public function dropdown()
    {
        $variants = ProductAttribute::all();

        return responseJson(ProductAttributeResource::collection($variants),'',200);
    }
}
