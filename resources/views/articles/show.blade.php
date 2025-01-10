@extends('layouts.app')

@section('content')
<div class="breadcrumbs">
    <div class="page-header d-flex align-items-center">
        <div class="container position-relative">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-6 text-center">
                    <h1>{{ $article->title }}</h1>
                </div>
            </div>
        </div>
    </div>
    <nav>
        <div class="container">
            <ol>
                <li><a href="{{ route('home') }}">Anasayfa</a></li>
                <li><a href="{{ route('articles.index') }}">Blog</a></li>
                <li>{{ $article->title }}</li>
            </ol>
        </div>
    </nav>
</div>

<section id="blog" class="blog">
    <div class="container" data-aos="fade-up">
        <div class="row g-5">
            <div class="col-lg-8">
                <article class="blog-details" itemscope itemtype="http://schema.org/Article">
                    <div class="post-img">
                        <img src="{{ asset($article->image) }}" alt="{{ $article->title }}" class="img-fluid">
                    </div>
                    <h2 class="title">{{ $article->title }}</h2>
                    <div class="meta-top">
                        <ul>
                            <li class="d-flex align-items-center">
                                <i class="bi bi-person"></i>
                                <a href="#">{{ $article->author_name }}</a>
                            </li>
                            <li class="d-flex align-items-center">
                                <i class="bi bi-clock"></i>
                                <a href="#"><time datetime="{{ $article->created_at }}">{{ $article->created_at->format('d M Y') }}</time></a>
                            </li>
                            <li class="d-flex align-items-center">
                                <i class="bi bi-folder"></i>
                                <a href="#">{{ $article->category }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="content" itemprop="articleBody">
                        {!! $article->content !!}
                    </div>
                </article>
            </div>

            <div class="col-lg-4">
                <div class="sidebar">
                    <div class="sidebar-item recent-posts">
                        <h3 class="sidebar-title">Son Yazılar</h3>
                        <div class="mt-3">
                            @foreach($recentArticles as $recentArticle)
                            <div class="post-item mt-3">
                                <img src="{{ asset($recentArticle->image) }}" alt="{{ $recentArticle->title }}" class="flex-shrink-0">
                                <div>
                                    <h3><a href="{{ route('articles.show', $recentArticle->slug) }}">{{ $recentArticle->title }}</a></h3>
                                    <time datetime="{{ $recentArticle->created_at }}">{{ $recentArticle->created_at->format('d M Y') }}</time>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 

@section('styles')
<style>
    /* Ana makale görseli için stiller */
    .post-img {
        margin-bottom: 20px;
        text-align: center;
        border-radius: 8px;
        overflow: hidden;
    }

    .post-img img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto;
    }

    /* Makale içeriğindeki görseller için stiller */
    .blog-details .content img {
        max-width: 100%;
        height: auto;
        margin: 15px auto;
        display: block;
        border-radius: 4px;
    }

    .blog-details .content figure {
        margin: 15px 0;
        padding: 0;
        max-width: 100%;
    }

    .blog-details .content figure img {
        width: 100%;
        height: auto;
        margin: 0 auto;
        display: block;
        border-radius: 4px;
    }

    .blog-details .content figure figcaption {
        text-align: center;
        font-size: 14px;
        color: #666;
        margin-top: 8px;
    }

    /* Yan menüdeki son yazılar için stiller */
    .post-item img {
        max-width: 100px;
        height: auto;
        border-radius: 4px;
    }
</style>
@endsection 