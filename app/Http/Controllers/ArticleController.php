<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('category')
            ->latest()
            ->paginate(9);
        return view('articles.index', compact('articles'));
    }

    public function show($slug)
    {
        $article = Article::with('category')
            ->where('slug', $slug)
            ->firstOrFail();
        $article->increment('views');
        
        $recentArticles = Article::latest()
            ->where('id', '!=', $article->id)
            ->take(5)
            ->get();
            
        $categories = Category::withCount('articles')->get();

        return view('articles.show', compact('article', 'recentArticles', 'categories'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $articles = Article::with('category')
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(9);
        
        return view('articles.category', [
            'category' => $category,
            'articles' => $articles
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $articles = Article::query()
            ->where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->latest()
            ->paginate(10);
        
        return view('articles.index', [
            'articles' => $articles,
            'search' => $query
        ]);
    }
}
