<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            // Önce eski category sütununu yedekleyelim
            $table->renameColumn('category', 'old_category');
            
            // Yeni category_id sütununu ekleyelim
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
            $table->renameColumn('old_category', 'category');
        });
    }
}; 