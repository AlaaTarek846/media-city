<?php

namespace App\Http\Resources\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutUsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image_1' => $this->image_1 ?? '',
            'image_2' => $this->image_2 ?? '',
            'title' => $this->current_translation?->title ?? '',
            'description' => $this->current_translation?->description ?? '',
            'translations' => $this->whenLoaded('translations', function () {
                return $this->translations->map(function ($translation) {
                    return [
                        'id' => $translation->id,
                        'locale' => $translation->locale,
                        'title' => $translation->title,
                        'description' => $translation->description,
                        'slug' => $translation->slug,
                        'keywords' => $translation->keywords,
                    ];
                });
            }),
            'features' => $this->whenLoaded('features', function () {
                return $this->features->map(function ($feature) {
                    return [
                        'id' => $feature->id,
                        'icon' => $feature->icon ?? '',
                        'title' => $feature->current_translation?->title ?? '',
                        'translations' => $feature->translations->map(function ($translation) {
                            return [
                                'id' => $translation->id,
                                'locale' => $translation->locale,
                                'title' => $translation->title,
                            ];
                        }),
                    ];
                });
            }),
            'statistics' => $this->whenLoaded('statistics', function () {
                return $this->statistics->map(function ($statistic) {
                    return [
                        'id' => $statistic->id,
                        'icon' => $statistic->icon ?? '',
                        'value' => $statistic->value ?? '',
                        'title' => $statistic->current_translation?->title ?? '',
                        'description' => $statistic->current_translation?->description ?? '',
                        'translations' => $statistic->translations->map(function ($translation) {
                            return [
                                'id' => $translation->id,
                                'locale' => $translation->locale,
                                'title' => $translation->title,
                                'description' => $translation->description,
                            ];
                        }),
                    ];
                });
            }),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
