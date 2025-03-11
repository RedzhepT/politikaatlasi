<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;

class ArticleController extends Controller
{
    private function cleanTitle($title)
    {
        // Önce tüm HTML etiketlerini temizle
        $cleanTitle = strip_tags($title);
        // Başlıktaki fazla boşlukları temizle
        $cleanTitle = preg_replace('/\s+/', ' ', $cleanTitle);
        // Başlık ve sondaki boşlukları temizle
        return trim($cleanTitle);
    }

    private function cleanContent($content)
    {
        // HTML etiketlerinden style özelliklerini temizle
        $content = preg_replace('/\s*style\s*=\s*"[^"]*"/', '', $content);
        
        // Fazla boşlukları temizle
        // $content = preg_replace('/\s+/', ' ', $content);
        
        return trim($content);
    }

    private function handleImageUpload($request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = 'uploads/articles/' . $filename;
            
            // Resmi public/uploads/articles dizinine kaydet
            $image->move(public_path('uploads/articles'), $filename);
            
            return $path;
        }
        
        return null;
    }

    public function index()
    {
        $articles = Article::query()
            ->latest()  // En son eklenenler önce
            ->when(request('search'), function($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('author_name', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString();  // URL parametrelerini koru

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'author' => 'required|string|max:255',
            'category' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = $this->handleImageUpload($request);

        // Kategori işleme
        $categoryName = $validated['category'];
        if (is_string($categoryName) && $this->isJson($categoryName)) {
            $categoryData = json_decode($categoryName, true);
            $categoryName = $categoryData['name'] ?? $categoryName;
        }

        $category = Category::firstOrCreate(
            ['name' => $categoryName],
            ['description' => $categoryName . ' kategorisindeki makaleler']
        );

        $article = new Article();
        $article->title = $this->cleanTitle($validated['title']);
        $article->content = $this->cleanContent($validated['content']);
        $article->author_name = $validated['author'];
        $article->category_id = $category->id;
        $article->slug = Str::slug($validated['title']);
        $article->is_published = false;
        $article->views = 0;
        $article->image = $imagePath;

        $article->save();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Makale başarıyla kaydedildi.');
    }

    public function edit(Article $article)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.articles.edit', [
            'article' => $article,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'author' => 'required|string|max:255',
            'category' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Görsel işleme
        if ($request->hasFile('image')) {
            // Eski görseli sil
            if ($article->image && file_exists(public_path($article->image))) {
                unlink(public_path($article->image));
            }
            $imagePath = $this->handleImageUpload($request);
            $article->image = $imagePath;
        }

        // Kategori işleme
        $categoryName = $validated['category'];
        if (is_string($categoryName) && $this->isJson($categoryName)) {
            $categoryData = json_decode($categoryName, true);
            $categoryName = $categoryData['name'] ?? $categoryName;
        }

        $category = Category::firstOrCreate(
            ['name' => $categoryName],
            ['description' => $categoryName . ' kategorisindeki makaleler']
        );

        // Article güncelleme
        $article->title = $this->cleanTitle($validated['title']);
        $article->content = $this->cleanContent($validated['content']);
        $article->author_name = $validated['author'];
        $article->slug = Str::slug($validated['title']);
        $article->category_id = $category->id;
        $article->is_published = $request->boolean('is_published');
        
        $article->save();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Makale başarıyla güncellendi.');
    }

    public function destroy(Article $article)
    {
        // Görseli sil
        if ($article->image && file_exists(public_path($article->image))) {
            unlink(public_path($article->image));
        }

        $article->delete();
        return redirect()->route('admin.articles.index')
            ->with('success', 'Makale başarıyla silindi.');
    }

    private function isJson($string) {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
} 