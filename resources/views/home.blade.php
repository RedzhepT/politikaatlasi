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
            @forelse($articles ?? [] as $article)
            <div class="col-xl-4 col-md-6">
                <article>
                    <div class="post-img">
                        <img src="{{ asset($article->image) }}" alt="" class="img-fluid">
                    </div>
                    <p class="post-category">{{ $article->category }}</p>
                    <h2 class="title">
                        <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                    </h2>
                    <div class="d-flex align-items-center">
                        <img src="{{ asset($article->author_image) }}" alt="" class="img-fluid post-author-img flex-shrink-0">
                        <div class="post-meta">
                            <p class="post-author">{{ $article->author_name }}</p>
                            <p class="post-date">
                                <time datetime="{{ $article->created_at }}">{{ $article->created_at->format('d M Y') }}</time>
                            </p>
                        </div>
                    </div>
                </article>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection 