<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $articles = DB::table('articles')->get();

        foreach ($articles as $article) {
            // HTML etiketlerini temizle
            $cleanTitle = strip_tags($article->title);
            // Fazla boşlukları temizle
            $cleanTitle = preg_replace('/\s+/', ' ', $cleanTitle);
            // Başlık ve sondaki boşlukları temizle
            $cleanTitle = trim($cleanTitle);

            DB::table('articles')
                ->where('id', $article->id)
                ->update(['title' => $cleanTitle]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Bu migration'ın geri alınması durumunda yapılacak bir işlem yok
        // çünkü orijinal başlıkları geri getirmek mümkün değil
    }
};
