<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ArticleCategoryRequest;
use App\Http\Resources\Dashboard\ArticleCategoryResource;
use App\Models\ArticleCategory;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;

class ArticleCategoryController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('can:articleCategory read', only: ['index']),
            new Middleware('can:articleCategory create', only: ['store']),
            new Middleware('can:articleCategory edit', only: ['update', 'show']),
            new Middleware('can:articleCategory delete', only: ['destroy']),
        ];
    }


    public function index(Request $request)
    {
        $articleCategories = ArticleCategory::searchAndFilter()->latest()->paginate(10);

        return responseJson(ArticleCategoryResource::collection($articleCategories->items()),'',200,getPaginates($articleCategories));
    }

    public function store(ArticleCategoryRequest $request)
    {
        $data = $request->validated();
        $articleCategory = ArticleCategory::create($data);
        $articleCategory->setTranslations($request->translations);
        return responseJson([],'Created Successfully',200);
    }

    public function show($id)
    {
        $articleCategory = ArticleCategory::with('translations')->find($id);
        return responseJson($articleCategory,'Data exited successfully',200);
    }

    public function update(ArticleCategoryRequest $request,$id)
    {
        $data = $request->validated();
        $articleCategory = ArticleCategory::find($id);
        $articleCategory->update($data);
        $articleCategory->setTranslations($request->translations);
        return responseJson($articleCategory,'Updated Successfully',200);
    }

    public function destroy($id)
    {
        $articleCategory = ArticleCategory::find($id);
        $articleCategory->delete();
        return responseJson([],'Deleted Successfully',200);
    }

    public function dropdown()
    {
        $articleCategory = ArticleCategory::all();
        return responseJson(ArticleCategoryResource::collection($articleCategory),'',200);
    }
}
