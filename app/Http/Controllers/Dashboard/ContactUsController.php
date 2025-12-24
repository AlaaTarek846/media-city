<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ContactUsRequest;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ContactUsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        // return [];
        return [
            new Middleware('can:contact us read', only: ['index']),
            new Middleware('can:contact us edit',only:['update']),
        ];
    }

    public function show($id)
    {
        $contactUs = ContactUs::with('translations')->findOrFail($id);
        return responseJson($contactUs, 'Updated Successfully', 200);
    }

    public function update(ContactUsRequest $request,$id){
        $data =$request->validated();
        $contactUs = ContactUs::find($id);
        $contactUs->update($data);
        $contactUs->setTranslations($request->translations);
        return responseJson($contactUs,'Updated Successfully', 200);
    }

}
