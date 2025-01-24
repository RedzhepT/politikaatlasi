@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section id="hero" class="hero">
    <div class="container position-relative">
        <div class="row gy-5" data-aos="fade-in">
            <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center text-center text-lg-start">
                <h2>Siyaseti Anlamak İçin <span>Doğru Adres</span></h2>
                <p>Politika Atlası, farklı yönetim biçimlerini ve siyasi kavramları herkesin anlayabileceği bir dille açıklayan eğitici bir platformdur.</p>
                <div class="d-flex justify-content-center justify-content-lg-start">
                    <a href="{{ route('articles.index') }}" class="btn-get-started">Makaleleri Keşfet</a>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2">
                <img src="{{ asset('assets/img/hero-img.svg') }}" class="img-fluid" alt="" data-aos="zoom-out" data-aos-delay="100">
            </div>
        </div>
    </div>
</section>

<!-- Öne Çıkan Kategoriler -->
<section id="featured-categories" class="featured-categories">
    <div class="container" data-aos="fade-up">
        <div class="section-header">
            <h2>Kategoriler</h2>
            <p>Siyasetin farklı alanlarını keşfedin</p>
        </div>

        <div class="row gy-4">
            @foreach($categories as $category)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                <div class="category-box">
                    <div class="icon"><i class="bi bi-book"></i></div>
                    <h3>{{ $category->name }}</h3>
                    <p>{{ $category->description }}</p>
                    <div class="category-meta">
                        <span class="article-count">{{ $category->articles_count }} Makale</span>
                    </div>
                    <a href="{{ route('articles.category', $category->slug) }}" class="read-more">
                        <span>Daha Fazla</span> <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Son Makaleler -->
<section id="recent-posts" class="recent-posts">
    <div class="container" data-aos="fade-up">
        <div class="section-header">
            <h2>Son Makaleler</h2>
            <p>En güncel içeriklerimizi keşfedin</p>
        </div>

        <div class="row gy-4">
            @forelse($articles as $article)
                <div class="col-xl-6 col-md-6">
                    <article class="post-card">
                        <div class="post-img">
                            <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="img-fluid">
                        </div>
                        <div class="post-content">
                            @if($article->category)
                                <p class="post-category">{{ $article->category->name }}</p>
                            @endif
                            <h3 class="title">
                                <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                            </h3>
                            <div class="meta">
                                <span class="author">{{ $article->author_name }}</span>
                                <span class="date">{{ $article->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">Henüz makale bulunmuyor.</p>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('articles.index') }}" class="btn btn-primary">
                Tüm Makaleleri Gör
            </a>
        </div>
    </div>
</section>

<!-- İstatistikler -->
<section id="stats" class="stats">
    <div class="container position-relative" data-aos="fade-up">
        <div class="row gy-4">
            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                    <span class="purecounter">{{ $articleCount ?? 0 }}</span>
                    <p>Makale</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                    <span class="purecounter">{{ $categoryCount ?? 0 }}</span>
                    <p>Kategori</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                    <span class="purecounter">{{ $authorCount ?? 0 }}</span>
                    <p>Kullanıcı</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                    <span class="purecounter">{{ $viewCount ?? 0 }}</span>
                    <p>Görüntülenme</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    /* Hero Section Styles */
    .hero {
        padding: 60px 0;
        background: var(--color-primary);
        color: #fff;
    }

    .hero h2 {
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .hero h2 span {
        color: var(--color-secondary);
    }

    .hero p {
        font-size: 18px;
        margin-bottom: 30px;
    }

    .btn-get-started {
        display: inline-block;
        padding: 12px 35px;
        background: var(--color-secondary);
        color: #fff;
        border-radius: 50px;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn-get-started:hover {
        background: var(--color-primary-dark);
        color: #fff;
    }

    /* Category Box Styles */
    .category-box {
        padding: 30px;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        background: #fff;
        height: 100%;
        transition: 0.3s;
    }

    .category-box:hover {
        transform: translateY(-5px);
    }

    .category-box .icon {
        width: 64px;
        height: 64px;
        background: var(--color-primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .category-box .icon i {
        font-size: 32px;
        color: #fff;
    }

    .category-box h3 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .category-box p {
        font-size: 15px;
        color: #6c757d;
    }

    .category-box .read-more {
        display: inline-flex;
        align-items: center;
        color: var(--color-primary);
        text-decoration: none;
        font-weight: 600;
        transition: 0.3s;
    }

    .category-box .read-more i {
        margin-left: 5px;
        transition: 0.3s;
    }

    .category-box .read-more:hover {
        color: var(--color-primary-dark);
    }

    .category-box .read-more:hover i {
        transform: translateX(5px);
    }

    /* Stats Section Styles */
    .stats {
        padding: 40px 0;
        background: #f6f6f6;
    }

    .stats-item {
        padding: 30px;
        background: #fff;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .stats-item span {
        font-size: 48px;
        display: block;
        color: var(--color-primary);
        font-weight: 700;
    }

    .stats-item p {
        padding: 0;
        margin: 0;
        font-size: 16px;
        font-weight: 500;
    }

    /* Post Card Styles */
    .post-card {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
        height: 100%;
        transition: 0.3s;
    }

    .post-card:hover {
        transform: translateY(-5px);
    }

    .post-img {
        position: relative;
        overflow: hidden;
        height: 200px;
    }

    .post-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .post-content {
        padding: 20px;
    }

    .post-category {
        color: var(--color-primary);
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 10px;
    }

    .post-content h3 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .post-content h3 a {
        color: #333;
        text-decoration: none;
        transition: 0.3s;
    }

    .post-content h3 a:hover {
        color: var(--color-primary);
    }

    .post-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 14px;
        color: #6c757d;
    }
</style>
@endsection 