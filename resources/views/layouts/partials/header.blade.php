<header id="header" class="header d-flex align-items-center">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
        <a href="{{ route('home') }}" class="logo d-flex align-items-center">
            <h1>Politika Atlası</h1>
        </a>
        
        <nav id="navbar" class="navbar">
            <ul>
                <li><a href="{{ route('home') }}">Anasayfa</a></li>
                <li><a href="{{ route('about') }}">Hakkımızda</a></li>
                <li><a href="{{ route('articles.index') }}">Blog</a></li>
                <li><a href="{{ route('contact') }}">İletişim</a></li>
                <li>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <i class="bi bi-search"></i>
                    </a>
                </li>
                @auth
                    @if(auth()->user()->is_admin)
                        <li><a href="{{ route('admin.dashboard') }}" class="btn-admin">
                            <i class="bi bi-speedometer2"></i> Admin Panel
                        </a></li>
                    @endif
                    <li class="nav-item dropdown d-lg-none">
                        <a href="#" class="nav-link mobile-dropdown-toggle">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="mobile-dropdown-menu">
                            <li><a class="dropdown-item" href="#">
                                <i class="bi bi-person"></i> Profil
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="px-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Çıkış Yap
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="d-lg-none">
                        <a href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> Giriş Yap
                        </a>
                    </li>
                    <li class="d-lg-none">
                        <a href="{{ route('register') }}">
                            <i class="bi bi-person-plus"></i> Kayıt Ol
                        </a>
                    </li>
                @endauth
            </ul>
        </nav>

        @auth
            <div class="user-menu d-none d-lg-block">
                <div class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle text-white" 
                            type="button" 
                            id="userDropdownBtn"
                            data-bs-toggle="dropdown" 
                            aria-expanded="false">
                        <i class="bi bi-person-circle"></i> 
                        {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdownBtn">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-person"></i> Profil
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="px-0">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right"></i> Çıkış Yap
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        @else
            <div class="auth-buttons d-none d-lg-flex gap-2">
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box-arrow-in-right"></i> Giriş Yap
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-person-plus"></i> Kayıt Ol
                </a>
            </div>
        @endauth

        <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
        <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
    </div>
</header>

@include('layouts.partials.search') 