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
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = $this->handleImageUpload($request);

        $article = new Article();
        $article->title = $this->cleanTitle($validated['title']);
        $article->content = $validated['content'];
        $article->author_name = $validated['author'];
        $article->category = $validated['category'];
        $article->slug = Str::slug($validated['title']);
        $article->is_published = false;
        $article->view_count = 0;
        $article->image = $imagePath;

        $article->save();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Makale başarıyla kaydedildi.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
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
        $category = Category::firstOrCreate(
            ['name' => $validated['category']],
            ['description' => $validated['category'] . ' kategorisindeki makaleler']
        );

        // Article güncelleme
        $article->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'author_name' => $validated['author'],
            'slug' => Str::slug($validated['title']),
            'category_id' => $category->id
        ]);

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
} 