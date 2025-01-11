<header id="header" class="header d-flex align-items-center">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
        <a href="{{ route('home') }}" class="logo d-flex align-items-center">
            <h1>PolitikaAtlası</h1>
        </a>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a href="{{ route('home') }}">Anasayfa</a></li>
                <li><a href="{{ route('about') }}">Hakkımızda</a></li>
                <li><a href="{{ route('articles.index') }}">Blog</a></li>
                <li><a href="{{ route('contact') }}">İletişim</a></li>
                @auth
                    @if(auth()->user()->is_admin)
                        <li><a href="{{ route('admin.dashboard') }}" class="btn-admin"><i class="bi bi-speedometer2"></i> Admin Panel</a></li>
                    @endif
                @endauth
            </ul>
        </nav>

        <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
        <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

        @auth
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link">Çıkış Yap</button>
            </form>
        @endauth
    </div>
</header> 