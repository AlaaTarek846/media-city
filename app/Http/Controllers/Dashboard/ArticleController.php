<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ArticleRequest;
use App\Http\Resources\Dashboard\ArticleCategoryResource;
use App\Http\Resources\Dashboard\ArticleQuiriesResource;
use App\Http\Resources\Dashboard\ArticleResource;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleClientQuiry;
use App\Models\ArticleTag;
use App\Models\ArticleSlugRedirect;
use Illuminate\Support\Str;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ArticleController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:article read', only: ['index']),
            new Middleware('can:article create', only: ['store']),
            new Middleware('can:article edit', only: ['update', 'show']),
            new Middleware('can:article delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $articles = Article::searchAndFilter()->latest()->paginate(10);
        return responseJson(ArticleResource::collection($articles->items()),'',200,getPaginates($articles));
    }

    public function store(ArticleRequest $request)
    {
        $data = $request->validated();
        $data['image'] = store_single_image($request->image);
        $article = Article::create($data);
        
        // Handle translations with keywords and slug
        $translations = $request->translations ?? [];
        foreach ($translations as $locale => $translation) {
            // Generate slug if not provided
            if (empty($translation['slug']) && !empty($translation['title'])) {
                $translation['slug'] = $this->generateUniqueSlug($translation['title'], $locale, $article->id);
            }
            
            // Convert keywords array to JSON if provided
            if (isset($translation['keywords']) && is_array($translation['keywords'])) {
                $translation['keywords'] = array_filter($translation['keywords']); // Remove empty values
            }
        }
        
        $article->setTranslations($translations);
        
        // Handle tags
        if ($request->has('tags') && is_array($request->tags)) {
            $article->tags()->sync($request->tags);
        }
        
        return responseJson([],'Created Successfully',200);
    }

    public function show($id)
    {
        $article = Article::with(['translations', 'tags'])->find($id);
        return responseJson($article,'Data exited successfully',200);
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $data = $request->validated();
        if($request->hasFile('image')){
            unlink_image_by_path($article->getAttributes()['image']);
            $data['image'] = store_single_image($request->image);
        }
        $article->update($data);
        
        // Handle translations with keywords and slug
        $translations = $request->translations ?? [];
        $oldTranslations = $article->translations->keyBy('locale');
        
        foreach ($translations as $locale => $translation) {
            $oldTranslation = $oldTranslations->get($locale);
            $oldSlug = $oldTranslation?->slug;
            
            // Generate slug if not provided
            if (empty($translation['slug']) && !empty($translation['title'])) {
                $translation['slug'] = $this->generateUniqueSlug($translation['title'], $locale, $article->id, $oldSlug);
            }
            
            // Handle slug redirect if slug changed
            if ($oldTranslation && $oldSlug && $translation['slug'] !== $oldSlug) {
                ArticleSlugRedirect::create([
                    'article_id' => $article->id,
                    'old_slug' => $oldSlug,
                    'locale' => $locale,
                    'new_slug' => $translation['slug'],
                ]);
            }
            
            // Convert keywords array to JSON if provided
            if (isset($translation['keywords']) && is_array($translation['keywords'])) {
                $translation['keywords'] = array_filter($translation['keywords']); // Remove empty values
            }
        }
        
        $article->setTranslations($translations);
        
        // Handle tags
        if ($request->has('tags')) {
            $article->tags()->sync($request->tags ?? []);
        }
        
        return responseJson($article,'Updated Successfully',200);
    }

    public function destroy(Article $article)
    {
        unlink_image_by_path($article->getAttributes()['image']);
        $article->delete();
        return responseJson([],'Deleted Successfully',200);
    }
    public function getCategories()
    {
        return responseJson(ArticleCategoryResource::collection(ArticleCategory::latest()->get()));
    }

    /**
     * Get all tags
     */
    public function getTags()
    {
        $tags = ArticleTag::latest()->get();
        return responseJson($tags, 'Tags retrieved successfully', 200);
    }

    /**
     * Create or get tag
     */
    public function createTag(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:article_tags,name',
        ]);

        $tag = ArticleTag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return responseJson($tag, 'Tag created successfully', 200);
    }

    /**
     * Search articles by tag, keyword, or title
     */
    public function search(Request $request)
    {
        $query = Article::query();

        if ($request->has('tag_id')) {
            $query->byTag($request->tag_id);
        }

        if ($request->has('keyword')) {
            $query->byKeyword($request->keyword);
        }

        if ($request->has('title')) {
            $query->whereHas('translations', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->title . '%');
            });
        }

        $articles = $query->with('translations')->latest()->paginate(10);
        return responseJson(ArticleResource::collection($articles->items()), '', 200, getPaginates($articles));
    }

    /**
     * Generate unique slug
     */
    private function generateUniqueSlug($title, $locale, $articleId = null, $currentSlug = null)
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (true) {
            $exists = \App\Models\LanguageTranslation::where('slug', $slug)
                ->where('locale', $locale)
                ->where('model_type', Article::class)
                ->when($articleId, function ($q) use ($articleId) {
                    $q->where('model_id', '!=', $articleId);
                })
                ->exists();

            if (!$exists || $slug === $currentSlug) {
                break;
            }

            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
