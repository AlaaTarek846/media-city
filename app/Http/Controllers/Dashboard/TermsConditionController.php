<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\TermsConditionRequest;
use App\Models\TermsCondition;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TermsConditionController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        // return [];
        return [
            new Middleware('can:terms conditions read', only: ['index']),
            new Middleware('can:terms conditions edit',only:['update']),
        ];
    }

    public function show($id)
    {
        $termsCondition = TermsCondition::with('translations')->findOrFail($id);
        return responseJson($termsCondition, 'Updated Successfully', 200);
    }

    public function update(TermsConditionRequest $request,$id){
        $data =$request->validated();
        $termsCondition = TermsCondition::find($id);
        $termsCondition->update($data);
        return responseJson($termsCondition,'Updated Successfully', 200);
    }
}

