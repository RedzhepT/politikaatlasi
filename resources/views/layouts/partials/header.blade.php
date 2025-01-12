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

        <div class="ms-3 position-relative">
            @auth
                <div class="dropdown">
                    <button class="btn btn-link text-white text-decoration-none p-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                    </button>
                    <ul class="dropdown-menu position-absolute end-0" style="z-index: 1021;">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right"></i> Çıkış Yap
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <div class="d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-box-arrow-in-right"></i> Giriş Yap
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-person-plus"></i> Kayıt Ol
                    </a>
                </div>
            @endauth
        </div>
    </div>
</header> 