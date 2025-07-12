<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Article::with(['author', 'category'])->latest();

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $articles = $query->paginate(10);
        
        // Get available categories
        $categories = Category::active()->orderBy('name')->get();

        return view('dashboard.articles.index', compact('articles', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->orderBy('name')->get();
        return view('dashboard.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        $data = $request->only(['title', 'content', 'category_id', 'excerpt', 'status']);
        $data['author_id'] = auth()->id();
        $data['slug'] = Str::slug($request->title);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('articles', 'public');
            $data['featured_image'] = $imagePath;
        }

        // Set published_at if status is published
        if ($request->status === 'published') {
            $data['published_at'] = now();
        }

        Article::create($data);

        return redirect()->route('dashboard.articles.index')
            ->with('success', 'Article created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $article->load(['author', 'category']);
        return view('dashboard.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $categories = Category::active()->orderBy('name')->get();
        return view('dashboard.articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        $data = $request->only(['title', 'content', 'category_id', 'excerpt', 'status']);
        $data['slug'] = Str::slug($request->title);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $imagePath = $request->file('featured_image')->store('articles', 'public');
            $data['featured_image'] = $imagePath;
        }

        // Set published_at if status is published and wasn't published before
        if ($request->status === 'published' && $article->status !== 'published') {
            $data['published_at'] = now();
        } elseif ($request->status === 'draft') {
            $data['published_at'] = null;
        }

        $article->update($data);

        return redirect()->route('dashboard.articles.index')
            ->with('success', 'Article updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        // Delete featured image if exists
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();

        return redirect()->route('dashboard.articles.index')
            ->with('success', 'Article deleted successfully!');
    }
}