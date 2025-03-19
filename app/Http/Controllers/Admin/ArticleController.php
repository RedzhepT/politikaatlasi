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
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

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
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|min:3|max:255',
                'category_id' => 'required|exists:categories,id',
                'content' => 'required|min:100',
                'author' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ], [
                'title.required' => 'Başlık alanı zorunludur.',
                'title.min' => 'Başlık en az 3 karakter olmalıdır.',
                'title.max' => 'Başlık en fazla 255 karakter olabilir.',
                'category_id.required' => 'Kategori seçimi zorunludur.',
                'category_id.exists' => 'Seçilen kategori geçerli değil.',
                'content.required' => 'İçerik alanı zorunludur.',
                'content.min' => 'İçerik en az 100 karakter olmalıdır.',
                'author.required' => 'Yazar alanı zorunludur.',
                'author.max' => 'Yazar adı en fazla 255 karakter olabilir.',
                'image.image' => 'Yüklenen dosya bir görsel olmalıdır.',
                'image.mimes' => 'Görsel JPEG, PNG, JPG, GIF veya WEBP formatında olmalıdır.',
                'image.max' => 'Görsel boyutu en fazla 2MB olabilir.'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $article = new Article();
            $article->title = $request->title;
            $article->slug = Str::slug($request->title);
            $article->content = $request->content;
            $article->category_id = $request->category_id;
            $article->author_name = $request->author;
            $article->is_published = $request->has('is_published');

            // Görsel yükleme
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . $image->getClientOriginalName();
                
                // Görseli farklı boyutlarda kaydet
                $sizes = [
                    'small' => [300, 200],
                    'medium' => [600, 400],
                    'large' => [900, 600]
                ];
                
                $imagePaths = [];
                foreach ($sizes as $size => $dimensions) {
                    $resizedImage = Image::make($image)
                        ->fit($dimensions[0], $dimensions[1])
                        ->encode('webp', 90);
                    
                    $path = 'articles/' . $size . '_' . $filename . '.webp';
                    Storage::disk('public')->put($path, $resizedImage);
                    $imagePaths[$size] = $path;
                }
                
                // Orijinal görseli kaydet
                $originalPath = 'articles/original_' . $filename . '.webp';
                Storage::disk('public')->put($originalPath, Image::make($image)->encode('webp', 90));
                $imagePaths['original'] = $originalPath;
                
                $article->image = $imagePaths;
            }

            $article->save();

            return response()->json([
                'success' => true,
                'message' => 'Makale başarıyla kaydedildi.',
                'redirect' => route('admin.articles.index')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bir hata oluştu: ' . $e->getMessage()
            ], 500);
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