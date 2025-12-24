<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProductRequest;
use App\Http\Resources\Dashboard\ProductResource;
use App\Http\Resources\Dashboard\ShowProductResource;
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
        $products = Product::searchAndFilter()->latest()->paginate(10);

        return responseJson(ProductResource::collection($products->items()),'',200,getPaginates($products));
    }



    public function store(ProductRequest $request)
    {

        $data = $request->validated();
        $data['image'] = store_single_image($request->image);
        $product = Product::create($data);
        $product->setTranslations($request->translations);
        if($request->hasFile('groupImages')){
            foreach ($request->groupImages as $image) {
                $url = store_single_image($image);
                $product->images()->create([
                    'image' => $url
                ]);
            }
        }
        $product_feature = ProductFeature::create([
            'product_id' => $product->id,
        ]);
        $product_feature->setTranslations($request->features);


        if (isset($data['attributes']) && is_array($data['attributes'])) {
            foreach ($data['attributes'] as $attribute) {
                ProductAttributeValue::create([
                    'product_id' => $product->id,
                    'attribute_id' => $attribute['attribute_id'],
                    'options' => is_array($attribute['options']) ? implode(' , ', $attribute['options']) : $attribute['options'],
                ]);
            }
        }


        foreach ($request->variant as $variant) {
            $product->variants()->create([
                'sku' => $variant['sku'],
                'attribute_values' => $variant['attribute_values'],
                'price_before_discount' => $variant['price_before_discount'],
                'discount_percentage' => $variant['discount_percentage'],
                'price' => $variant['price'],
                'quantity' => $variant['quantity'],
                'status' => $variant['status'],
            ]);
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
        $product->update($data);
        $product->setTranslations($request->translations);
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
        $product->features()->delete();
        $product_feature = ProductFeature::create([
            'product_id' => $product->id,
        ]);
        $product_feature->setTranslations($request->features);

        // Delete old attribute values not present in the new data
        if (isset($data['attributes']) && is_array($data['attributes'])) {
            $attributeIds = array_column($data['attributes'], 'attribute_id');
            ProductAttributeValue::where('product_id', $product->id)
            ->whereNotIn('attribute_id', $attributeIds)
            ->delete();

            foreach ($data['attributes'] as $attribute) {
                $attributeValue = ProductAttributeValue::where('product_id', $product->id)
                    ->where('attribute_id', $attribute['attribute_id'])
                    ->first();

                if ($attributeValue) {
                    $attributeValue->update([
                        'options' => is_array($attribute['options']) ? implode(' , ', $attribute['options']) : $attribute['options'],
                    ]);
                } else {
                    ProductAttributeValue::create([
                        'product_id' => $product->id,
                        'attribute_id' => $attribute['attribute_id'],
                        'options' => is_array($attribute['options']) ? implode(' , ', $attribute['options']) : $attribute['options'],
                    ]);
                }
            }
        } else {
            // If no attributes sent, remove all
            ProductAttributeValue::where('product_id', $product->id)->delete();
        }

        // Update or create variants
        foreach ($request->variant as $variant) {
            $existingVariant = $product->variants()->where('attribute_values', $variant['attribute_values'])->first();
            if ($existingVariant) {
                $existingVariant->update([
                    'attribute_values' => $variant['attribute_values'],
                    'price_before_discount' => $variant['price_before_discount'],
                    'discount_percentage' => $variant['discount_percentage'],
                    'price' => $variant['price'],
                    'quantity' => $variant['quantity'],
                    'status' => $variant['status'],
                ]);
            } else {
                $product->variants()->create([
                    'sku' => $variant['sku'],
                    'attribute_values' => $variant['attribute_values'],
                    'price_before_discount' => $variant['price_before_discount'],
                    'discount_percentage' => $variant['discount_percentage'],
                    'price' => $variant['price'],
                    'quantity' => $variant['quantity'],
                    'status' => $variant['status'],
                ]);
            }
        }

        return responseJson($product,'Updated Successfully',200);
    }

    public function destroy(Product $product)
    {
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
