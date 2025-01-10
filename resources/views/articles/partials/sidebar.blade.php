<div class="sidebar">
    <div class="sidebar-item search-form">
        <h3 class="sidebar-title">Ara</h3>
        <form action="{{ route('articles.search') }}" class="mt-3">
            <input type="text" name="q">
            <button type="submit"><i class="bi bi-search"></i></button>
        </form>
    </div>

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
            @foreach($recentArticles as $article)
            <div class="post-item mt-3">
                <img src="{{ asset($article->image) }}" alt="">
                <div>
                    <h4><a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a></h4>
                    <time datetime="{{ $article->created_at }}">{{ $article->created_at->format('d M Y') }}</time>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div> 