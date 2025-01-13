@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section id="hero" class="hero">
    <div class="container position-relative">
        <div class="row gy-5" data-aos="fade-in">
            <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center text-center text-lg-start">
                <h2>Politika Atlası'na <span>Hoş Geldiniz</span></h2>
                <p>Güncel siyasi gelişmeler, analizler ve daha fazlası...</p>
            </div>
            <div class="col-lg-6 order-1 order-lg-2">
                <img src="{{ asset('assets/img/hero-img.svg') }}" class="img-fluid" alt="" data-aos="zoom-out" data-aos-delay="100">
            </div>
        </div>
    </div>
</section>

<!-- Son Makaleler Section -->
<section id="recent-posts" class="recent-posts sections-bg">
    <div class="container" data-aos="fade-up">
        <div class="section-header">
            <h2>Son Makaleler</h2>
        </div>

        <div class="row gy-4">
            @forelse($articles as $article)
            <div class="col-xl-4 col-md-6">
                <article class="post-card">
                    <div class="post-img">
                        <img src="{{ asset($article->image) }}" alt="{{ $article->title }}" class="img-fluid">
                    </div>
                    <div class="post-content">
                        <p class="post-category">{{ $article->category }}</p>
                        <h3 class="title">
                            <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                        </h3>
                        <p class="excerpt">{{ $article->excerpt }}</p>
                        <div class="post-meta d-flex align-items-center">
                            <div class="post-author-info">
                                <p class="post-author">{{ $article->author_name }}</p>
                                <p class="post-date">
                                    <time datetime="{{ $article->created_at }}">{{ $article->created_at->format('d M Y') }}</time>
                                </p>
                            </div>
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

        <div class="mt-5">
            {{ $articles->links() }}
        </div>
    </div>
</section>

@section('styles')
<style>
    .post-card {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .post-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
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

    .post-category {
        color: var(--color-primary);
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .title {
        font-size: 1.25rem;
        margin-bottom: 12px;
        line-height: 1.4;
    }

    .title a {
        color: var(--color-default);
        text-decoration: none;
    }

    .title a:hover {
        color: var(--color-primary);
    }

    .excerpt {
        color: #666;
        font-size: 0.95rem;
        margin-bottom: 15px;
        flex: 1;
    }

    .post-meta {
        border-top: 1px solid #eee;
        padding-top: 15px;
    }

    .post-author {
        font-weight: 600;
        color: var(--color-default);
        margin-bottom: 4px;
    }

    .post-date {
        font-size: 0.85rem;
        color: #666;
    }
</style>
@endsection
@endsection 