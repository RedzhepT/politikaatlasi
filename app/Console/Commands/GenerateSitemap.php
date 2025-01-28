<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use App\Models\Article;
use App\Models\Category;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate the sitemap.';

    public function handle()
    {
        // Domain adını .env dosyasından al
        $domain = config('app.url');
        
        $sitemap = \Spatie\Sitemap\Sitemap::create();

        // Ana sayfa
        $sitemap->add(Url::create($domain)
            ->setChangeFrequency('daily')
            ->setPriority(1.0));

        // Statik sayfalar
        $sitemap->add(Url::create($domain . '/hakkimizda')
            ->setChangeFrequency('monthly')
            ->setPriority(0.8));

        $sitemap->add(Url::create($domain . '/iletisim')
            ->setChangeFrequency('monthly')
            ->setPriority(0.8));

        // Makaleler
        Article::all()->each(function (Article $article) use ($sitemap, $domain) {
            $sitemap->add(Url::create($domain . "/ulke-yonetim-sistemleri/{$article->slug}")
                ->setLastModificationDate($article->updated_at)
                ->setChangeFrequency('weekly')
                ->setPriority(0.9));
        });

        // Kategoriler
        Category::all()->each(function (Category $category) use ($sitemap, $domain) {
            $sitemap->add(Url::create($domain . "/ulke-yonetim-sistemleri/kategori/{$category->slug}")
                ->setChangeFrequency('weekly')
                ->setPriority(0.8));
        });

        // XML dosyasını public klasörüne kaydet
        $sitemap->writeToFile(public_path('sitemap.xml'));

        // Log tutma
        \Log::info('Sitemap generated at: ' . now());
        
        $this->info('Sitemap generated successfully.');
    }
} 