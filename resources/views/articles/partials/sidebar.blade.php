<div class="sidebar">

    <div class="sidebar-item categories">
        <h3 class="sidebar-title">Kategoriler</h3>
        <ul class="mt-3">
            @foreach($categories as $category)
            <li>
                <a href="{{ route('articles.category', $category->slug) }}">
                    {{ $category->name }} <span>({{ $category->articles_count }})</span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="sidebar-item recent-posts">
        <h3 class="sidebar-title">Son Yazılar</h3>

        <div class="mt-3">
            @foreach($recentArticles as $recentArticle)
                <div class="post-item">
                    <div class="row g-0 align-items-center">
                        <div class="col-lg-4 col-md-2 col-sm-2">
                            @if($recentArticle->image)
                                <img src="{{ $recentArticle->image_url }}" alt="{{ $recentArticle->title }}" class="img-fluid">
                            @endif
                        </div>
                        <div class="col-8 ps-3">
                            <div class="post-content">
                                <h4 class="text-truncate" style="margin-left: -10px;"><a href="{{ route('articles.show', $recentArticle->slug) }}">{{ $recentArticle->title }}</a></h4>
                                <time datetime="{{ $recentArticle->created_at }}">{{ $recentArticle->created_at->format('d M Y') }}</time>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
.sidebar {
    margin: 0 0 60px 20px;
    padding: 30px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.sidebar .sidebar-title {
    font-size: 20px;
    font-weight: 700;
    padding: 0;
    margin: 0;
    color: var(--color-default);
}

.sidebar .sidebar-item {
    margin-bottom: 30px;
}

.sidebar .recent-posts img {
    width: 100%;
    height: 70px;
    object-fit: cover;
    border-radius: 4px;
}

.sidebar .recent-posts h4 {
    font-size: 15px;
    font-weight: 600;
    line-height: 1.2;
    margin: 0 0 4px 0;
}

.sidebar .recent-posts h4 a {
    color: var(--color-default);
    transition: 0.3s;
    text-decoration: none;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
    max-height: 2.4em;
}

.sidebar .recent-posts h4 a:hover {
    color: var(--color-primary);
}

.sidebar .recent-posts time {
    display: block;
    font-size: 13px;
    color: #999;
    margin: 0;
    line-height: 1;
}

.sidebar .post-item {
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}

.sidebar .post-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.sidebar .post-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 100%;
}

@media (max-width: 768px) {
    .sidebar {
        margin: 0;
        padding: 20px;
    }
    
    .sidebar .recent-posts h4 {
        font-size: 14px;
        line-height: 1.2;
    }
    
    .sidebar .post-content {
        padding-left: 10px;
    }
    
    .sidebar .recent-posts img {
        height: 60px;
    }
}
</style> 