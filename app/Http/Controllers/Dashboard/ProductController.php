<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProductRequest;
use App\Http\Resources\Dashboard\ProductResource;
use App\Http\Resources\Dashboard\ShowProductResource;
use App\Models\DepartmentCategory;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductFeature;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:product read', only: ['index']),
            new Middleware('can:product create', only: ['store']),
            new Middleware('can:product edit', only: ['update', 'show']),
            new Middleware('can:product delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $products = Product::with(['department', 'category', 'brand', 'variants'])
            ->withCount(['orderItems', 'carts'])
            ->searchAndFilter()
            ->latest()
            ->paginate(10);

        return responseJson(ProductResource::collection($products->items()),'',200,getPaginates($products));
    }



    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['image'] = store_single_image($request->image);

        // الحصول على department_category_id إذا كان موجوداً
        $departmentCategory = DepartmentCategory::where('department_id', $data['department_id'])
            ->where('category_id', $data['category_id'])
            ->first();

        if ($departmentCategory) {
            $data['department_category_id'] = $departmentCategory->id;
        }

        $product = Product::create($data);
        $product->setTranslations($request->translations);

        // حفظ Product Features
        $product_feature = ProductFeature::create([
            'product_id' => $product->id,
        ]);
        $product_feature->setTranslations($request->features);


        // حفظ الصور الإضافية
        if($request->hasFile('groupImages')){
            foreach ($request->groupImages as $image) {
                $url = store_single_image($image);
                $product->images()->create([
                    'image' => $url
                ]);
            }
        }

        // حفظ Variants
        foreach ($request->variant as $variant) {
            $attributeValues = $variant['attribute_values'] ?? '';
            // Convert empty string to null for JSON column
            if ($attributeValues === '' || $attributeValues === null) {
                $attributeValues = null;
            } else {
                // If it's a string, convert it to array for JSON storage
                $attributeValues = is_string($attributeValues) ? [$attributeValues] : $attributeValues;
            }

            $variantData = [
                'sku' => $variant['sku'] ?? '',
                'attribute_values' => $attributeValues,
                'discount_percentage' => $variant['discount_percentage'] ?? 0,
                'price' => $variant['price'] ?? 0,
                'price_before_discount' => $variant['price_before_discount'] ?? 0,
                'quantity' => $variant['quantity'] ?? 0,
                'status' => $variant['status'] ?? true,
            ];



            $product->variant()->create($variantData);
        }

        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $product = Product::with('translations')->find($id);
        if (!$product) {
            return responseJson([], 'Product not found', 404);
        }
        return responseJson(new ShowProductResource($product), '', 200);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        if($request->hasFile('image')){
            unlink_image_by_path($product->getAttributes()['image']);
            $data['image'] = store_single_image($request->image);
        }

        // الحصول على department_category_id إذا كان موجوداً
        $departmentCategory = DepartmentCategory::where('department_id', $data['department_id'])
            ->where('category_id', $data['category_id'])
            ->first();

        if ($departmentCategory) {
            $data['department_category_id'] = $departmentCategory->id;
        }

        $product->update($data);
        $product->setTranslations($request->translations);

        // حفظ Product Features
        $product->features()->delete();
        $product_feature = ProductFeature::create([
            'product_id' => $product->id,
        ]);
        $product_feature->setTranslations($request->features);

        // حفظ الصور الإضافية
        if($request->hasFile('groupImages')){
            foreach($product->images as $image) {
                unlink_image_by_path($image->getAttributes()['image']);
            }
            $product->images()->delete();
            foreach ($request->groupImages as $image) {
                $url = store_single_image($image);
                $product->images()->create([
                    'image' => $url
                ]);
            }
        }

        // حفظ Variants - تعديل على القديم فقط
        foreach ($request->variant as $variant) {
            $updateProduct = $product->variants()->first();

                $updateData = [
                    'sku'                 => $variant['sku'] ?? '',
                    'attribute_values'    => $variant['attribute_values'] ?? '',
                    'price'               => $variant['price'] ?? 0,
                    'price_before_discount'=> $variant['price_before_discount'] ?? 0,
                    'discount_percentage' => $variant['discount_percentage'] ?? 0,
                    'quantity'            => $variant['quantity'] ?? 0,
                    'status'              => $variant['status'] ?? true,
                ];

                $updateProduct->update($updateData);
        }

        return responseJson($product,'Updated Successfully',200);
    }

    public function destroy(Product $product)
    {
        $product->loadCount(['orderItems', 'carts']);
        if ($product->order_items_count > 0 || $product->carts_count > 0) {
            return responseJson([], 'Cannot delete this product because it is in orders or carts', 422);
        }
        unlink_image_by_path($product->getAttributes()['image']);
        $product->delete();
        return responseJson([],'Deleted Successfully',200);
    }

    public function dropdown()
    {
        $countries = Product::all();

        return responseJson(ProductResource::collection($countries),'',200);
    }
}
