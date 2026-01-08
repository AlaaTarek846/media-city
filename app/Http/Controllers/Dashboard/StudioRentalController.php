<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StudioRentalRequest;
use App\Http\Resources\Dashboard\StudioRentalResource;
use App\Models\StudioRental;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controllers\Middleware;

class StudioRentalController extends Controller
{
    public static function middleware(): array
    {
        // return [];
        return [
            new Middleware('can:studioRental read', only: ['index']),
            new Middleware('can:studioRental create', only: ['store']),
            new Middleware('can:studioRental edit', only: ['update', 'show']),
            new Middleware('can:studioRental delete', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $studioRentals = StudioRental::with('translations')->searchAndFilter()->latest()->paginate(10);
        return responseJson(StudioRentalResource::collection($studioRentals->items()), 'studioRentals', 200, getPaginates($studioRentals));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudioRentalRequest $request)
    {
        $data = $request->validated();
        $studioRental = StudioRental::create($data);
        $studioRental->setTranslations($request->translations);
        
        // Handle images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = store_single_image($image, 'studio_rentals/');
                $studioRental->images()->create([
                    'image' => $imagePath
                ]);
            }
        }
        
        return responseJson([], 'Created Successfully', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $studioRental = StudioRental::with(['translations', 'images'])->findOrFail($id);
        return responseJson($studioRental, 'Data retrieved successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudioRentalRequest $request,$id)
    {
        $data = $request->validated();
        $studioRental = StudioRental::findOrFail($id);
        $studioRental->update($data);
        $studioRental->setTranslations($request->translations);
        
        // Handle deleted images
        if ($request->has('deleted_images') && is_array($request->deleted_images)) {
            foreach ($request->deleted_images as $imageId) {
                $image = Image::find($imageId);
                if ($image && $image->imageable_type === StudioRental::class && $image->imageable_id == $studioRental->id) {
                    unlink_image_by_path($image->image);
                    $image->delete();
                }
            }
        }
        
        // Handle new images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = store_single_image($image, 'studio_rentals/');
                $studioRental->images()->create([
                    'image' => $imagePath
                ]);
            }
        }
        
        return responseJson(new StudioRentalResource($studioRental->load('images')),'Updated Successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $studioRental = StudioRental::findOrFail($id);
        $studioRental->delete();
        return responseJson([],'Deleted Successfully',200);
    }
}
