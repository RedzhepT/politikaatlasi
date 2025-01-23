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
        // Kategorileri oluştur
        $categories = [
            'Siyasi Sistemler',
            'Demokrasi',
            'İdeolojiler',
            'Uluslararası İlişkiler',
            'Ekonomi Politikaları',
            'Siyasi Tarih'
        ];

        foreach ($categories as $categoryName) {
            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                ['description' => $categoryName . ' kategorisindeki makaleler']
            );
        }
    }
} 