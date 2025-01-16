@extends('layouts.app')

@section('content')
<div class="breadcrumbs">
    <div class="page-header d-flex align-items-center">
        <div class="container position-relative">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-6 text-center">
                    <h2>Arama Sonuçları</h2>
                    <p>"{{ $query }}" için {{ $articles->total() }} sonuç bulundu</p>
                </div>
            </div>
        </div>
    </div>
    <nav>
        <div class="container">
            <ol>
                <li><a href="{{ route('home') }}">Anasayfa</a></li>
                <li>Arama</li>
            </ol>
        </div>
    </nav>
</div>

<section id="blog" class="blog">
    <div class="container" data-aos="fade-up">
        <div class="row gy-4 posts-list">
            @forelse($articles as $article)
                <div class="col-xl-4 col-md-6">
                    <article class="blog-post">
                        <div class="post-img">
                            <img src="{{ asset($article->image) }}" alt="" class="img-fluid">
                        </div>
                        @if($article->category)
                            <p class="post-category">{{ $article->category->name }}</p>
                        @endif
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
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Aramanızla eşleşen sonuç bulunamadı.
                        <br>
                        <a href="{{ route('articles.index') }}" class="btn btn-primary mt-3">Tüm Makaleleri Görüntüle</a>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="blog-pagination">
            {{ $articles->appends(['query' => $query])->links() }}
        </div>
    </div>
</section>
@endsection 