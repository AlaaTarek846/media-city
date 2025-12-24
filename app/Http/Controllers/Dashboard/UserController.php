<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\UserResource;
use App\Http\Resources\Dashboard\UserShowResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        // return [];
        return [
            new Middleware('can:user read', only: ['index']),
        ];
    }

    public function index(Request $request)
    {
        $users = User::searchAndFilter()->latest()->paginate(10);

        return responseJson(UserResource::collection($users->items()), 'ContactMessage', 200, getPaginates($users));
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return responseJson('User not found', 'error', 404);
        }
        return responseJson(new UserShowResource($user), 'User', 200);
    }

    public function update(Request $request,$id){
        $user = User::find($id);
        $user->update([
            'status' => $request->status,
        ]);

        return responseJson([],'Created Successfully',200);
    }

}
