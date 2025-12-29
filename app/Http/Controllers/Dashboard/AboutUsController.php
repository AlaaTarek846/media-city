<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AboutUsRequest;
use App\Http\Resources\Dashboard\AboutUsResource;
use App\Models\AboutUs;
use App\Models\AboutUsFeature;
use App\Models\AboutUsStatistic;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AboutUsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('can:about us read', only: ['index', 'show']),
            new Middleware('can:about us create', only: ['store']),
            new Middleware('can:about us edit', only: ['update']),
            new Middleware('can:about us delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $aboutUs = AboutUs::with(['features.translation', 'statistics.translation'])
            ->searchAndFilter()
            ->latest()
            ->paginate(10);

        return responseJson(
            AboutUsResource::collection($aboutUs->items()),
            'AboutUs fetched successfully',
            200,
            getPaginates($aboutUs)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AboutUsRequest $request)
    {
        $data = $request->validated();

        // Handle image_1
        if ($request->hasFile('image_1')) {
            $data['image_1'] = store_single_image($request->image_1);
        }

        // Handle image_2
        if ($request->hasFile('image_2')) {
            $data['image_2'] = store_single_image($request->image_2);
        }

        $aboutUs = AboutUs::create($data);
        $aboutUs->setTranslations($request->translations);

        // Handle features
        if ($request->has('features') && is_array($request->features)) {
            foreach ($request->features as $index => $feature) {
                $featureData = [
                    'about_us_id' => $aboutUs->id,
                ];

                // Handle icon file upload
                if ($request->hasFile("features.{$index}.icon")) {
                    $featureData['icon'] = store_single_image($request->file("features.{$index}.icon"));
                }

                $featureModel = AboutUsFeature::create($featureData);
                if (isset($feature['translations'])) {
                    $featureModel->setTranslations($feature['translations']);
                }
            }
        }

        // Handle statistics
        if ($request->has('statistics') && is_array($request->statistics)) {
            foreach ($request->statistics as $statistic) {
                $statisticData = [
                    'about_us_id' => $aboutUs->id,
                    'value' => $statistic['value'] ?? null,
                ];

                if (isset($statistic['icon']) && is_file($statistic['icon'])) {
                    $statisticData['icon'] = store_single_image($statistic['icon']);
                } elseif (isset($statistic['icon'])) {
                    $statisticData['icon'] = $statistic['icon'];
                }

                $statisticModel = AboutUsStatistic::create($statisticData);
                if (isset($statistic['translations'])) {
                    $statisticModel->setTranslations($statistic['translations']);
                }
            }
        }

        return responseJson(
            new AboutUsResource($aboutUs->load(['features.translation', 'statistics.translation'])),
            'Created Successfully',
            200
        );
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $aboutUs = AboutUs::with(['translations', 'features.translation', 'statistics.translation'])
            ->findOrFail($id);
        
        return responseJson(new AboutUsResource($aboutUs), 'AboutUs fetched successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AboutUsRequest $request, $id)
    {
        $aboutUs = AboutUs::findOrFail($id);
        $data = [];

        // Handle image_1
        if ($request->hasFile('image_1')) {
            if ($aboutUs->getAttributes()['image_1'] ?? null) {
                unlink_image_by_path($aboutUs->getAttributes()['image_1']);
            }
            $data['image_1'] = store_single_image($request->image_1);
        }

        // Handle image_2
        if ($request->hasFile('image_2')) {
            if ($aboutUs->getAttributes()['image_2'] ?? null) {
                unlink_image_by_path($aboutUs->getAttributes()['image_2']);
            }
            $data['image_2'] = store_single_image($request->image_2);
        }

        $aboutUs->update($data);
        $aboutUs->setTranslations($request->translations);

        // Handle features update
        if ($request->has('features') && is_array($request->features)) {
            // Delete old features not in the request
            $featureIds = array_filter(array_column($request->features, 'id'));
            AboutUsFeature::where('about_us_id', $aboutUs->id)
                ->whereNotIn('id', $featureIds)
                ->delete();

            foreach ($request->features as $index => $feature) {
                $featureData = [];

                // Handle icon file upload
                if ($request->hasFile("features.{$index}.icon")) {
                    $featureData['icon'] = store_single_image($request->file("features.{$index}.icon"));
                }

                if (isset($feature['id'])) {
                    // Update existing feature
                    $featureModel = AboutUsFeature::findOrFail($feature['id']);
                    if (isset($featureData['icon']) && $featureModel->getAttributes()['icon']) {
                        unlink_image_by_path($featureModel->getAttributes()['icon']);
                    }
                    if (!empty($featureData)) {
                        $featureModel->update($featureData);
                    }
                    if (isset($feature['translations'])) {
                        $featureModel->setTranslations($feature['translations']);
                    }
                } else {
                    // Create new feature
                    $featureData['about_us_id'] = $aboutUs->id;
                    $featureModel = AboutUsFeature::create($featureData);
                    if (isset($feature['translations'])) {
                        $featureModel->setTranslations($feature['translations']);
                    }
                }
            }
        }

        // Handle statistics update
        if ($request->has('statistics') && is_array($request->statistics)) {
            // Delete old statistics not in the request
            $statisticIds = array_filter(array_column($request->statistics, 'id'));
            AboutUsStatistic::where('about_us_id', $aboutUs->id)
                ->whereNotIn('id', $statisticIds)
                ->delete();

            foreach ($request->statistics as $index => $statistic) {
                $statisticData = [
                    'value' => $statistic['value'] ?? null,
                ];

                // Handle icon file upload
                if ($request->hasFile("statistics.{$index}.icon")) {
                    $statisticData['icon'] = store_single_image($request->file("statistics.{$index}.icon"));
                }

                if (isset($statistic['id'])) {
                    // Update existing statistic
                    $statisticModel = AboutUsStatistic::findOrFail($statistic['id']);
                    if (isset($statisticData['icon']) && $statisticModel->getAttributes()['icon']) {
                        unlink_image_by_path($statisticModel->getAttributes()['icon']);
                    }
                    if (!empty($statisticData)) {
                        $statisticModel->update($statisticData);
                    }
                    if (isset($statistic['translations'])) {
                        $statisticModel->setTranslations($statistic['translations']);
                    }
                } else {
                    // Create new statistic
                    $statisticData['about_us_id'] = $aboutUs->id;
                    $statisticModel = AboutUsStatistic::create($statisticData);
                    if (isset($statistic['translations'])) {
                        $statisticModel->setTranslations($statistic['translations']);
                    }
                }
            }
        }

        return responseJson(
            new AboutUsResource($aboutUs->load(['features.translation', 'statistics.translation'])),
            'Updated Successfully',
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $aboutUs = AboutUs::findOrFail($id);
        
        // Delete images
        if ($aboutUs->getAttributes()['image_1'] ?? null) {
            unlink_image_by_path($aboutUs->getAttributes()['image_1']);
        }
        if ($aboutUs->getAttributes()['image_2'] ?? null) {
            unlink_image_by_path($aboutUs->getAttributes()['image_2']);
        }

        // Delete related features and statistics (cascade will handle this, but we'll delete images)
        foreach ($aboutUs->features as $feature) {
            if ($feature->getAttributes()['icon']) {
                unlink_image_by_path($feature->getAttributes()['icon']);
            }
        }
        foreach ($aboutUs->statistics as $statistic) {
            if ($statistic->getAttributes()['icon']) {
                unlink_image_by_path($statistic->getAttributes()['icon']);
            }
        }

        $aboutUs->delete();

        return responseJson([], 'Deleted Successfully', 200);
    }
}
