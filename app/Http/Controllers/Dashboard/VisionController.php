<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\HistoryMissionVisionRequest;
use App\Models\Vision;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class VisionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        // return [];
        return [
            new Middleware('can:vision read', only: ['show']),
            new Middleware('can:vision edit',only:['update']),
        ];
    }

    public function show($id)
    {
        $vision = Vision::with('translations')->findOrFail($id);
        return responseJson($vision, 'Updated Successfully', 200);
    }

    public function update(HistoryMissionVisionRequest $request,$id){
        $vision = Vision::find($id);
        if($request->hasFile('image')){
            unlink_image_by_path($vision->getAttributes()['image']);
            $data['image'] = store_single_image($request->image);
        }
        
        $vision->update($data);
        $vision->setTranslations($request->translations);
        return responseJson($vision,'Updated Successfully', 200);
    }

}
