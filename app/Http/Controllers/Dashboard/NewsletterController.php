<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\NewsletterResource;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class NewsletterController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        // return [];
        return [
            new Middleware('can:newsletter read', only: ['index']),
        ];
    }

    public function index(Request $request)
    {
        $Newsletter = Newsletter::searchAndFilter()->latest()->paginate(10);

        return responseJson(NewsletterResource::collection($Newsletter->items()), 'Newsletter', 200, getPaginates($Newsletter));
    }

}
