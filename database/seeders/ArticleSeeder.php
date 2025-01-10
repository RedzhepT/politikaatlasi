<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        // Mevcut makaleyi güncelle
        DB::table('articles')
            ->where('slug', 'isvicrenin-benzersiz-federal-yonetim-sistemi')
            ->update([
                'image' => 'assets/img/cta-bg.jpg',
                'author_image' => 'assets/img/team/team-2.jpg',
                'updated_at' => now()
            ]);

        // Eğer makale yoksa yeni ekle
        if (DB::table('articles')->where('slug', 'isvicrenin-benzersiz-federal-yonetim-sistemi')->doesntExist()) {
            DB::table('articles')->insert([
                'title' => 'İsviçre\'nin Benzersiz Federal Yönetim Sistemi',
                'slug' => Str::slug('İsviçrenin Benzersiz Federal Yönetim Sistemi'),
                'content' => '<p>İsviçre, dünya üzerindeki en özgün ve başarılı federal sistemlerden birine sahip olan ülkedir. 26 kantondan oluşan bu küçük Orta Avrupa ülkesi, doğrudan demokrasi uygulamaları ve çok kültürlü yapısıyla dikkat çekmektedir.</p>

<h3>Federal Yapının Temelleri</h3>

<p>İsviçre federal sistemi, 1848 Anayasası\'yla kurulmuş ve zaman içinde geliştirilerek bugünkü halini almıştır. Sistem, üç temel yönetim düzeyinden oluşur: federal hükümet, kantonlar ve belediyeler. Her düzeyin kendine özgü yetki ve sorumlulukları vardır.</p>

<p>Federal düzeyde, yedi üyeli Federal Konsey (Bundesrat) yürütme organı olarak görev yapar. Konsey üyeleri, Federal Meclis tarafından dört yıllığına seçilir ve her biri federal bir departmanın başında yer alır. Konsey başkanlığı, üyeler arasında yıllık rotasyonla değişir.</p>

<h3>Kantonların Özerkliği</h3>

<p>İsviçre\'nin en dikkat çekici özelliklerinden biri, kantonların sahip olduğu geniş özerkliktir. Her kanton kendi anayasasına, parlamentosuna ve hükümetine sahiptir. Eğitim, sağlık, polis ve vergilendirme gibi birçok alanda kantonlar birincil yetkiye sahiptir.</p>

<p>Kantonlar, federal yasaların uygulanmasında da önemli rol oynar. Federal hükümet, kantonların özerkliğine saygı göstermek zorundadır ve ancak anayasada açıkça belirtilen alanlarda yetki kullanabilir.</p>

<h3>Doğrudan Demokrasi Uygulamaları</h3>

<p>İsviçre\'nin yönetim sistemini benzersiz kılan bir diğer özellik, doğrudan demokrasi araçlarının yaygın kullanımıdır. Vatandaşlar, federal düzeyde yapılan yasal düzenlemeleri referanduma götürebilir ve anayasa değişikliği önerebilir. 50.000 imza ile herhangi bir federal yasa referanduma götürülebilirken, 100.000 imza ile anayasa değişikliği teklif edilebilir.</p>

<h3>Çok Dilli ve Çok Kültürlü Yapı</h3>

<p>Federal sistem, ülkenin dört resmi dili (Almanca, Fransızca, İtalyanca ve Romanş) ve farklı kültürel kimlikleri bir arada tutmayı başarmıştır. Her kanton kendi resmi dilini belirleyebilir ve kültürel politikalarını oluşturabilir.</p>

<h3>Ekonomik ve Sosyal Başarı</h3>

<p>Bu benzersiz yönetim sistemi, İsviçre\'nin ekonomik ve sosyal açıdan dünyanın en başarılı ülkelerinden biri olmasına katkıda bulunmuştur. Yerel özerklik ve federal yapı, rekabeti teşvik ederken, doğrudan demokrasi uygulamaları vatandaşların sisteme olan güvenini artırmıştır.</p>',
                'image' => 'assets/img/cta-bg.jpg',
                'category' => 'Siyasi Sistemler',
                'author_name' => 'Dr. Ahmet Yılmaz',
                'author_image' => 'assets/img/team/default-author.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
} 