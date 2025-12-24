<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\TeamRequest;
use App\Http\Resources\Dashboard\TeamResource;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class TeamController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:team read', only: ['index']),
            new Middleware('can:team create', only: ['store']),
            new Middleware('can:team edit', only: ['update', 'show']),
            new Middleware('can:team delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $instagram = Team::searchAndFilter()->latest()->paginate(10);

        return responseJson(TeamResource::collection($instagram->items()),'',200,getPaginates($instagram));
    }



    public function store(TeamRequest $request)
    {
        $data = $request->validated();
        $data['image'] = store_single_image($request->image);
        $team = Team::create($data);
        $team->setTranslations($request->translations);

        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $team = Team::with('translations')->find($id);
        return responseJson($team,'Data exited successfully',200);
    }

    public function update(TeamRequest $request, $id)
    {
        $team = Team::find($id);
        $data = $request->validated();
        if($request->hasFile('image')){
            unlink_image_by_path($team->getAttributes()['image']);
            $data['image'] = store_single_image($request->image);
        }
        $team->update($data);
        $team->setTranslations($request->translations);
        return responseJson($team,'Updated Successfully',200);
    }

    public function destroy($id)
    {
        $team = Team::find($id);
        if (!$team) {
            return responseJson([],'Data not found',404);
        }
        unlink_image_by_path($team->getAttributes()['image']);
        $team->delete();
        return responseJson([],'Deleted Successfully',200);
    }
}
