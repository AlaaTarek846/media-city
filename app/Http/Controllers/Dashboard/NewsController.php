<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\NewsRequest;
use App\Http\Resources\Dashboard\NewsResource;
use App\Models\News;
use App\Models\NewsDetail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class NewsController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:news read', only: ['index']),
            new Middleware('can:news create', only: ['store']),
            new Middleware('can:news edit', only: ['update', 'show']),
            new Middleware('can:news delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $news = News::searchAndFilter()->latest()->paginate(10);

        return responseJson(NewsResource::collection($news->items()),'',200,getPaginates($news));
    }

    public function store(NewsRequest $request)
    {
        $data = $request->validated();
        $data['image'] = store_single_image($request->image);
        $news=News::create($data);
        $news->setTranslations($request->translations);
        $details= NewsDetail::create([
            'news_id' => $news->id
        ]);
        $details->setTranslations($request->details);
        return responseJson([],'Created Successfully',200);
    }

    public function show($id)
    {
        $news = News::with(['translations','details','details.translations'])->find($id);
        return responseJson($news,'Data exited successfully',200);
    }

    public function update(NewsRequest $request, News $news)
    {
        $data = $request->validated();
        if($request->hasFile('image')){
            unlink_image_by_path($news->getAttributes()['image']);
            $data['image'] = store_single_image($request->image);
        }
        $news->update($data);
        $news->setTranslations($request->translations);
        $news->details->setTranslations($request->details);
        return responseJson($news,'Updated Successfully',200);
    }

    public function destroy(News $news)
    {
        unlink_image_by_path($news->getAttributes()['image']);
        $news->delete();
        return responseJson([],'Deleted Successfully',200);
    }
}
