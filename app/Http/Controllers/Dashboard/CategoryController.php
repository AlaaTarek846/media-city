<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CategoryRequest;
use App\Http\Resources\Dashboard\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class CategoryController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:category read', only: ['index']),
            new Middleware('can:category create', only: ['store']),
            new Middleware('can:category edit', only: ['update', 'show']),
            new Middleware('can:category delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $categories = Category::searchAndFilter()->latest()->paginate(10);

        return responseJson(CategoryResource::collection($categories->items()),'',200,getPaginates($categories));
    }



    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $data['image'] = store_single_image($request->image);
        $departments = $data['departments'] ?? [];
        unset($data['departments']);
        
        $category=Category::create($data);
        $category->setTranslations($request->translations);
        
        if (!empty($departments)) {
            // إضافة العلاقات الجديدة (في حالة create لا توجد علاقات موجودة)
            $category->departments()->attach($departments);
        }
        
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $category = Category::with(['translations', 'departments'])->find($id);
        $category->departments_ids = $category->departments->pluck('id')->toArray();
        return responseJson($category,'Data exited successfully',200);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        if($request->hasFile('image')){
            unlink_image_by_path($category->getAttributes()['image']);
            $data['image'] = store_single_image($request->image);
        }
        $departments = $data['departments'] ?? [];
        unset($data['departments']);
        
        $category->update($data);
        $category->setTranslations($request->translations);
        
        // إضافة فقط العلاقات الجديدة بدون حذف الموجودة
        if (!empty($departments)) {
            $existingDepartments = $category->departments->pluck('id')->toArray();
            $newDepartments = array_diff($departments, $existingDepartments);
            
            if (!empty($newDepartments)) {
                $category->departments()->attach($newDepartments);
            }
        }
        
        return responseJson($category,'Updated Successfully',200);
    }

    public function destroy(Category $category)
    {
        unlink_image_by_path($category->getAttributes()['image']);
        $category->delete();
        return responseJson([],'Deleted Successfully',200);
    }

     public function dropdown(Request $request)
    {
        $query = Category::select('id')
            ->with(['translations' => function($query) {
                $query->where('locale', app()->getLocale());
            }]);

        // إذا تم إرسال department_id، جلب الفئات المرتبطة بهذا القسم فقط
        if ($request->has('department_id') && $request->department_id) {
            $query->whereHas('departments', function($q) use ($request) {
                $q->where('departments.id', $request->department_id);
            });
        }

        $categories = $query->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'title' => $category->translations->pluck('title')->first() ?: '',
                ];
            });

        return responseJson($categories,'',200);
    }
}
