@extends('layouts.app')

@section('content')
<!-- Hero Section -->
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
</div>

<!-- Breadcrumb Navigation -->
<div class="breadcrumb-nav">
    <div class="container">
        <ol>
            <li><a href="{{ route('home') }}">Anasayfa</a></li>
            <li><a href="{{ route('articles.index') }}">Blog</a></li>
            <li>{{ $article->title }}</li>
        </ol>
    </div>
</div>

<!-- Article Content -->
<section id="blog" class="blog">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8 order-1">
                <article class="blog-details">
                    @if($article->image)
                    <div class="post-img">
                        <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="img-fluid">
                    </div>
                    @endif

                    <article itemscope itemtype="http://schema.org/Article">
                        <meta itemprop="headline" content="{{ $article->title }}">
                        <meta itemprop="datePublished" content="{{ $article->created_at->toIso8601String() }}">
                        <meta itemprop="dateModified" content="{{ $article->updated_at->toIso8601String() }}">
                        
                        <div itemprop="author" itemscope itemtype="http://schema.org/Person">
                            <meta itemprop="name" content="{{ $article->author_name }}">
                        </div>

                        <div itemprop="articleBody">
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
                                        <i class="bi bi-eye"></i>
                                        <a href="#">{{ $article->views }} Görüntülenme</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="content">
                                {!! preg_replace('/<h3/i', '<h2', preg_replace('/<\/h3>/i', '</h2>', $article->content)) !!}
                            </div>
                        </div>
                    </article>
                </article>
            </div>

            <div class="col-lg-4 order-lg-2 order-3">
                @include('articles.partials.sidebar')
            </div>

                    <!-- Yorumlar Bölümü -->
            <div class="row order-lg-3 order-2">
                <div class="col-lg-8">
                    <div class="comments-section mt-5">
                        <h3>Yorumlar</h3>
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <!-- Geçici: Yorum sistemi bakım aşamasındadır -->
                
                        @forelse($article->comments as $comment)
                            <div class="comment border-bottom py-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex align-items-center">
                                        <strong>{{ $comment->user->name }}</strong>
                                        <small class="text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</small>
                                    </div>
                                    
                                    @if(auth()->id() === $comment->user_id)
                                        <div class="comment-actions">
                                            <button class="btn btn-link btn-sm text-primary p-0 me-2" 
                                                    title="Düzenle"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editModal{{ $comment->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button class="btn btn-link btn-sm text-danger p-0" 
                                                    title="Sil" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal{{ $comment->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal{{ $comment->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Yorumu Düzenle</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="content{{ $comment->id }}" class="form-label">Yorumunuz</label>
                                                                <textarea class="form-control" 
                                                                        id="content{{ $comment->id }}" 
                                                                        name="content" 
                                                                        rows="4" 
                                                                        required>{{ $comment->content }}</textarea>
                                                            </div>
                                                            <small class="text-muted">Son düzenleme: {{ $comment->updated_at->format('d.m.Y H:i') }}</small>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                                                            <button type="submit" class="btn btn-primary">Güncelle</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $comment->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Yorumu Sil</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="comment-preview mb-3 p-3 bg-light rounded">
                                                            <small class="text-muted d-block mb-2">{{ $comment->created_at->format('d.m.Y H:i') }}</small>
                                                            <p class="mb-0">{{ $comment->content }}</p>
                                                        </div>
                                                        <p class="mb-0 text-danger">Bu yorumu silmek istediğinizden emin misiniz?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Sil</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <p class="mb-0">{{ $comment->content }}</p>
                            </div>
                        @empty
                            <div class="alert alert-info">
                                Henüz yorum yapılmamış. İlk yorumu siz yapın!
                            </div>
                        @endforelse

                        <div class="comment-form mt-4">
                            @auth
                                <form action="{{ route('comments.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                                    <div class="mb-3">
                                        <label for="content" class="form-label">Yorumunuz</label>
                                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                                id="content" 
                                                name="content" 
                                                rows="3" 
                                                required></textarea>
                                        @error('content')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Yorum Yap</button>
                                </form>
                            @else
                                <div class="alert alert-info">
                                    Yorum bırakmak için <a href="{{ route('login') . '?redirect=' . request()->url() }}">giriş yapmalısınız</a>.
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('styles')
<style>
    /* Navbar için stiller */
    .header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 997;
        background: var(--color-primary);
    }

    .header .logo h1 {
        color: white !important;
    }

    /* Hero Section için stiller */
    .breadcrumbs {
        padding: 140px 0 60px 0;
        min-height: 30vh;
        position: relative;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-color: var(--color-primary);
        color: #fff;
    }

    .breadcrumbs .page-header {
        padding: 0;
    }

    .breadcrumbs .page-header h1 {
        font-size: 56px;
        font-weight: 500;
        color: #fff;
        font-family: var(--font-primary);
    }

    /* Breadcrumb Navigation için stiller */
    .breadcrumb-nav {
        padding: 20px 0;
        background: #f6f6f6;
    }

    .breadcrumb-nav ol {
        display: flex;
        flex-wrap: wrap;
        list-style: none;
        margin: 0;
        padding: 0;
        font-size: 16px;
    }

    .breadcrumb-nav ol li {
        display: flex;
        align-items: center;
    }

    .breadcrumb-nav ol li + li {
        padding-left: 10px;
    }

    .breadcrumb-nav ol li + li::before {
        display: inline-block;
        padding-right: 10px;
        color: #6c757d;
        content: "/";
    }

    .breadcrumb-nav ol li a {
        color: #6c757d;
        text-decoration: none;
        transition: 0.3s;
    }

    .breadcrumb-nav ol li a:hover {
        color: var(--color-primary);
    }

    .breadcrumb-nav ol li:last-child {
        color: #999;
    }

    /* İçerik için padding */
    .blog {
        padding: 40px 0;
    }

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

    /* Yorum bölümü için stiller */
    .comments-section {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #eee;
    }

    .comment {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .comment:last-child {
        border-bottom: none !important;
    }

    .comment strong {
        color: var(--color-primary);
    }

    .comment small {
        font-size: 0.85rem;
    }

    .comment p {
        margin-top: 0.5rem;
        color: #333;
    }

    /* Responsive düzenlemeler */
    @media (max-width: 768px) {
        .breadcrumbs {
            padding: 120px 0 40px 0;
        }

        .breadcrumbs .page-header h1 {
            font-size: 36px;
        }
    }
</style>
@endsection 