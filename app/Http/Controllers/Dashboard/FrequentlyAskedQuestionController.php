<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\FrequentlyAskedQuestionRequest;
use App\Http\Resources\Dashboard\FrequentlyAskedQuestionResource;
use App\Models\FrequentlyAskedQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controllers\Middleware;

class FrequentlyAskedQuestionController extends Controller
{
    public static function middleware(): array
    {
        // return [];
        return [
            new Middleware('can:frequently asked question read', only: ['index']),
            new Middleware('can:frequently asked question create', only: ['store']),
            new Middleware('can:frequently asked question edit', only: ['update', 'show']),
            new Middleware('can:frequently asked question delete', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $frequentlyAskedQuestions = FrequentlyAskedQuestion::where(function ($q) use ($request) {
            $q->when($request->client_type, function ($q) use ($request) {
                $q->where('client_type',$request->client_type);
            });
        })->searchAndFilter()->latest()->paginate(10);
        return responseJson(FrequentlyAskedQuestionResource::collection($frequentlyAskedQuestions->items()), 'FrequentlyAskedQuestion', 200, getPaginates($frequentlyAskedQuestions));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FrequentlyAskedQuestionRequest $request)
    {
        $data = $request->validated();
        $frequentlyAskedQuestion = FrequentlyAskedQuestion::create($data);
        $frequentlyAskedQuestion->setTranslations($request->translations);
        return responseJson([], 'Created Successfully', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $frequentlyAskedQuestion = FrequentlyAskedQuestion::with('translations')->findOrFail($id);
        return responseJson($frequentlyAskedQuestion, 'Updated Successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FrequentlyAskedQuestionRequest $request,$id)
    {
        $data = $request->validated();
        $frequentlyAskedQuestion = FrequentlyAskedQuestion::findOrFail($id);
        $frequentlyAskedQuestion->update($data);
        $frequentlyAskedQuestion->setTranslations($request->translations);
        return responseJson(new FrequentlyAskedQuestionResource($frequentlyAskedQuestion),'Updated Successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $frequentlyAskedQuestion = FrequentlyAskedQuestion::findOrFail($id);
        $frequentlyAskedQuestion->delete();
        return responseJson([],'Deleted Successfully',200);
    }
}
