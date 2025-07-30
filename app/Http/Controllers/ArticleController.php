<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::published()->with(['author', 'category'])->latest('published_at');

        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%')
                    ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            });
        }

        $articles = $query->paginate(12);

        // Get available categories that have published articles
        $categories = Category::active()
            ->whereHas('articles', function ($query) {
                $query->published();
            })
            ->orderBy('name')
            ->get();

        return view('articles.index', compact('articles', 'categories'));
    }

    public function show(Article $article)
    {
        // Only show published articles
        if (
            $article->status !== 'published' ||
            !$article->published_at ||
            $article->published_at > now()
        ) {
            abort(404);
        }

        // Increment views count
        $article->increment('views');

        // Load relationships
        $article->load(['author', 'category']);

        // Get related articles (same category, exclude current article)
        $relatedArticles = Article::published()
            ->with(['author', 'category'])
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->limit(3)
            ->get();

        return view('articles.show', compact('article', 'relatedArticles'));
    }
}
