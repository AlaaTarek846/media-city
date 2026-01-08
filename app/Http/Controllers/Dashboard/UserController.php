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
            new Middleware('can:user delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $users = User::searchAndFilter()->withCount(['orders', 'addresses', 'carts'])->latest()->paginate(10);

        return responseJson(UserResource::collection($users->items()), 'ContactMessage', 200, getPaginates($users));
    }

    public function show($id)
    {
        $user = User::with(['personProfile', 'companyProfile', 'studioProfile', 'addresses', 'orders', 'favorites', 'reviews'])->find($id);
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

    public function destroy($id)
    {
        $user = User::withCount(['orders', 'addresses', 'carts'])->find($id);
        if ($user->orders_count > 0 || $user->addresses_count > 0 || $user->carts_count > 0) {
            return responseJson([], 'Cannot delete this user because they have related data', 422);
        }
        $user->delete();
        return responseJson([],'Deleted Successfully',200);
    }

}
