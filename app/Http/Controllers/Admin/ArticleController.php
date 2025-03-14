<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;

class ArticleController extends Controller
{
    public function __construct(
        private readonly ImageService $imageService
    ) {}

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
        // İzin verilen HTML etiketleri
        $allowedTags = '<p><br><h1><h2><h3><h4><h5><h6><ul><ol><li><strong><em><u><s><blockquote><a><img><figure><figcaption>';
        
        // HTML özel karakterlerini decode et
        $content = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        // Önce tüm style özelliklerini temizle
        $content = preg_replace('/\s*style\s*=\s*"[^"]*"/', '', $content);
        
        // İzin verilen etiketler dışındaki tüm HTML'i temizle
        $content = strip_tags($content, $allowedTags);
        
        // Fazla boşlukları temizle
        $content = preg_replace('/\s+/', ' ', $content);
        
        // Başlık ve sondaki boşlukları temizle
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
            'content' => 'required|string',
            'featured_image' => 'required|image|mimes:jpeg,png,jpg|max:5120', // 5MB limit
        ]);

        try {
            // Görsel işleme
            $imageUrls = $this->imageService->optimizeAndStore(
                $request->file('featured_image'),
                'articles/images',
                [
                    'thumb' => [150, 150],   // Admin panel için küçük önizleme
                    'small' => [400, 300],    // Mobil görünüm için
                    'medium' => [800, 600],   // Tablet görünüm için
                    'large' => [1200, 900],   // Desktop görünüm için
                ]
            );

            // Makale oluşturma
            $article = Article::create([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'featured_image' => json_encode($imageUrls),
            ]);

            return redirect()
                ->route('admin.articles.index')
                ->with('success', 'Makale başarıyla oluşturuldu.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Görsel yüklenirken bir hata oluştu.')
                ->withInput();
        }
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
            'category' => 'required|exists:categories,id',
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

        // Article güncelleme
        $article->title = $this->cleanTitle($validated['title']);
        $article->content = $this->cleanContent($validated['content']);
        $article->author_name = $validated['author'];
        $article->slug = Str::slug($validated['title']);
        $article->category_id = $validated['category'];
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