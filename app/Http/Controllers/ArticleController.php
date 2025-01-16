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
        $query = $request->input('query');
        
        // Boş sorgu kontrolü
        if (empty($query)) {
            return redirect()->route('articles.index')
                ->with('info', 'Lütfen bir arama terimi girin.');
        }

        // Minimum 3 karakter kontrolü
        if (strlen($query) < 3) {
            return back()
                ->with('error', 'Arama terimi en az 3 karakter olmalıdır.');
        }

        $articles = Article::with('category')
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('content', 'LIKE', "%{$query}%")
                  ->orWhereHas('category', function($q) use ($query) {
                      $q->where('name', 'LIKE', "%{$query}%");
                  });
            })
            ->when($query, function($q) use ($query) {
                // Tam eşleşmelere daha yüksek öncelik ver
                return $q->orderByRaw('
                    CASE 
                        WHEN title LIKE ? THEN 1
                        WHEN title LIKE ? THEN 2
                        WHEN content LIKE ? THEN 3
                        ELSE 4
                    END
                ', [
                    $query,             // Tam eşleşme
                    "%{$query}%",       // Kısmi eşleşme
                    "%{$query}%"        // İçerikte eşleşme
                ]);
            })
            ->latest()
            ->paginate(9);
            
        return view('articles.search', [
            'articles' => $articles,
            'query' => $query
        ]);
    }
}
