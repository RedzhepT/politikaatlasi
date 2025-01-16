<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryDataMigrationSeeder extends Seeder
{
    public function run()
    {
        // Mevcut kategorileri topla
        $existingCategories = Article::distinct('old_category')->pluck('old_category');
        
        // Her kategori için yeni Category kaydı oluştur
        foreach ($existingCategories as $categoryName) {
            if (!$categoryName) continue;
            
            $category = Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'description' => $categoryName . ' kategorisindeki makaleler'
            ]);
            
            // Bu kategorideki makaleleri güncelle
            Article::where('old_category', $categoryName)
                  ->update(['category_id' => $category->id]);
        }
    }
} 