<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AreaRequest;
use App\Http\Resources\Dashboard\AreaResource;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AreaController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:area read', only: ['index']),
            new Middleware('can:area create', only: ['store']),
            new Middleware('can:area edit', only: ['update', 'show']),
            new Middleware('can:area delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $areas = Area::searchAndFilter()->latest()->paginate(10);

        return responseJson(AreaResource::collection($areas->items()),'',200,getPaginates($areas));
    }



    public function store(AreaRequest $request)
    {
        $data = $request->validated();
        $area = Area::create($data);
        $area->setTranslations($request->translations);
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $area = Area::with('translations')->find($id);
        return responseJson($area,'Data exited successfully',200);
    }

    public function update(AreaRequest $request,$id)
    {
        $data = $request->validated();
        $area = Area::find($id);
        $area->update($data);
        $area->setTranslations($request->translations);
        return responseJson($area,'Updated Successfully',200);
    }

    public function destroy($id)
    {
        $area = Area::find($id);
        $area->delete();
        return responseJson([],'Deleted Successfully',200);
    }

    public function dropdown()
    {
        $areas = Area::all();

        return responseJson(AreaResource::collection($areas),'',200);
    }
}
