<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\DepartmentRequest;
use App\Http\Resources\Dashboard\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class DepartmentController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:department read', only: ['index']),
            new Middleware('can:department create', only: ['store']),
            new Middleware('can:department edit', only: ['update', 'show']),
            new Middleware('can:department delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $departments = Department::withCount('categories')->searchAndFilter()->latest()->paginate(10);
        return responseJson(DepartmentResource::collection($departments->items()),'',200,getPaginates($departments));
    }



    public function store(DepartmentRequest $request)
    {
        $data = $request->validated();
        $data['image'] = store_single_image($request->image);
        $categories = $data['categories'] ?? [];
        unset($data['categories']);

        $department=Department::create($data);
        $department->setTranslations($request->translations);

        if (!empty($categories)) {
            // إضافة العلاقات الجديدة (في حالة create لا توجد علاقات موجودة)
            $department->categories()->attach($categories);
        }

        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $department = Department::with(['translations', 'categories'])->find($id);
        $department->categories_ids = $department->categories->pluck('id')->toArray();
        return responseJson($department,'Data exited successfully',200);
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        $data = $request->validated();
        if($request->hasFile('image')){
            unlink_image_by_path($department->getAttributes()['image']);
            $data['image'] = store_single_image($request->image);
        }
        $categories = $data['categories'] ?? [];
        unset($data['categories']);

        $department->update($data);
        $department->setTranslations($request->translations);

        // إضافة العلاقات الجديدة وحذف القديمة فقط إذا لم تكن مرتبطة بمنتجات
        if (!empty($categories)) {
            $existingCategories = $department->categories->pluck('id')->toArray();
            $newCategories = array_diff($categories, $existingCategories);
            $categoriesToRemove = array_diff($existingCategories, $categories);

            // إضافة العلاقات الجديدة
            if (!empty($newCategories)) {
                $department->categories()->attach($newCategories);
            }

            // حذف العلاقات القديمة فقط إذا لم تكن مرتبطة بمنتجات
            if (!empty($categoriesToRemove)) {
                foreach ($categoriesToRemove as $categoryId) {
                    // التحقق من وجود منتجات مرتبطة بهذه العلاقة
                    $hasProducts = \App\Models\Product::where('department_id', $department->id)
                        ->where('category_id', $categoryId)
                        ->exists();

                    // إذا لم تكن هناك منتجات مرتبطة، يمكن حذف العلاقة
                    if (!$hasProducts) {
                        $department->categories()->detach($categoryId);
                    }
                }
            }
        }

        return responseJson($department,'Updated Successfully',200);
    }

    public function destroy(Department $department)
    {
        unlink_image_by_path($department->getAttributes()['image']);
        $department->delete();
        return responseJson([],'Deleted Successfully',200);
    }

     public function dropdown()
    {
        $departments = Department::select('id')
            ->with(['translations' => function($query) {
                $query->where('locale', app()->getLocale());
            }])
            ->get()
            ->map(function ($departments) {
                return [
                    'id' => $departments->id,
                    'title' => $departments->translations->pluck('title')->first() ?: '',
                ];
            });

        return responseJson($departments,'',200);
    }
}
