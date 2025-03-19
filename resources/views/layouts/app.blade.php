<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Google Analytics -->
    @if(config('services.google.analytics_id'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google.analytics_id') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ config('services.google.analytics_id') }}');
    </script>
    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <!-- Alternatif PNG favicon için -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <title>@yield('title', 'Ülke Yönetim Biçimleri') | Politika Atlası</title>
    <meta name="description" content="@yield('meta_description', 'Dünya ülkelerinin yönetim sistemleri, siyasi yapıları ve devlet sistemleri hakkında detaylı bilgiler.')">
    <meta name="keywords" content="@yield('meta_keywords', 'yönetim sistemleri, siyasi sistemler, devlet yönetimi') @if(isset($article)), {{ $article->title }}@endif">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.css') }}">
    @yield('styles')

    <!-- Pagination Styles -->
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

        .pagination .page-item .page-link {
            min-width: 2.5rem;
            height: 2.5rem;
            padding: 0 0.75rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            color: var(--color-primary);
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            text-decoration: none;
            transition: all 0.2s;
        }

        .pagination .page-item .page-link:hover {
            background: var(--color-primary);
            color: #fff;
            border-color: var(--color-primary);
        }

        .pagination .page-item.active .page-link {
            background: var(--color-primary);
            color: #fff;
            border-color: var(--color-primary);
        }

        .pagination .page-item.disabled .page-link {
            background: #f8f9fa;
            color: #6c757d;
            border-color: #dee2e6;
            cursor: not-allowed;
            pointer-events: none;
        }

        .pagination-info {
            text-align: center;
            margin-top: 1rem;
            color: #666;
            font-size: 0.875rem;
        }

        /* Dropdown item içindeki ikon ve metin arasındaki boşluğu ayarla */
        .dropdown-item i {
            margin-right: 0.5rem;
            width: 1rem;
            text-align: center;
        }

        /* Dropdown item hover efekti */
        .dropdown-item:hover {
            background-color: var(--color-primary);
            color: white !important;
        }

        /* Çıkış Yap butonu için özel stil */
        .dropdown-item.text-danger:hover {
            background-color: #dc3545;
            color: white !important;
        }

        /* Dropdown menu pozisyonu ve gölgesi */
        .dropdown-menu {
            margin-top: 0.5rem;
            border: none;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            min-width: 200px;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Mobil görünüm için dropdown stilleri */
        @media (max-width: 991.98px) {
            .navbar {
                position: fixed;
                top: 72px;
                right: -100%;
                width: 100%;
                height: calc(100vh - 72px);
                background: var(--color-primary);
                transition: 0.3s;
                overflow-y: auto;
                padding: 1rem 0;
                z-index: 9997;
                display: block;
            }

            .navbar ul {
                display: block;
                padding: 0;
                margin: 0;
                width: 100%;
            }

            .navbar ul li {
                padding: 0.5rem 1.5rem;
                width: 100%;
            }

            .navbar ul li a {
                display: block;
                width: 100%;
                font-size: 16px;
                color: #fff;
                padding: 0.75rem 0;
            }

            /* Dropdown menü için düzenlemeler */
            .navbar .mobile-dropdown-menu {
                position: static;
                display: none;
                padding: 0.5rem 0 0.5rem 1.5rem;
                margin: 0;
                width: 100%;
                background: rgba(255, 255, 255, 0.1);
            }

            .navbar .mobile-dropdown-menu.show {
                display: block;
            }
        }

        /* Desktop görünüm için dropdown stilleri */
        @media (min-width: 992px) {
            .dropdown-menu {
                background: white;
            }

            .dropdown-item:hover {
                background-color: var(--color-primary);
                color: white;
            }

            .dropdown-item.text-danger:hover {
                background-color: #dc3545;
                color: white !important;
            }
        }

        /* Dropdown toggle button'daki fazla padding'i kaldır */
        .navbar .dropdown .btn-link {
            padding: 0.5rem !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;  /* İkon ile metin arasında sabit boşluk */
        }

        /* İkonun genişliğini sabitle */
        .navbar .dropdown .btn-link i {
            width: 1rem;
            text-align: center;
        }

        /* Mobil menüdeki dropdown için */
        @media (max-width: 991px) {
            .navbar .dropdown-menu {
                background-color: rgba(255, 255, 255, 0.1);
                margin: 0;
                padding: 0.5rem 0;
            }
            
            .navbar .dropdown-item {
                color: #fff;
                padding: 0.5rem 1.5rem;
            }
            
            .navbar .dropdown-item:hover {
                background-color: rgba(255, 255, 255, 0.2);
            }

            /* Mobil dropdown ok işareti için */
            .mobile-dropdown-toggle {
                position: relative;
                padding-right: 2rem !important;
            }

            .mobile-dropdown-toggle::after {
                /* content: "\F282"; */
                font-family: "bootstrap-icons";
                position: absolute;
                right: 0.5rem;
                top: 50%;
                transform: translateY(-50%);
                transition: transform 0.2s ease-in-out;
            }

            .mobile-dropdown-toggle[aria-expanded="true"]::after {
                transform: translateY(-50%) rotate(180deg);
            }
        }

        /* Dropdown temel stilleri */
        .dropdown-toggle::after {
            content: "\F282" !important;  /* Bootstrap Icons chevron-down */
            font-family: "bootstrap-icons" !important;
            border: none !important;  /* Varsayılan border oku kaldır */
            vertical-align: middle;
            margin-left: 0.5rem;
            transition: transform 0.2s ease-in-out;
        }
        
        /* Dropdown açıkken ok yukarı dönsün */
        .dropdown-toggle[aria-expanded="true"]::after {
            transform: rotate(180deg);
        }
        
        .dropdown-menu {
            margin-top: 0.5rem !important;
            border: none;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        
        /* Desktop dropdown için */
        @media (min-width: 992px) {
            .user-menu .dropdown-menu {
                background: white;
                min-width: 200px;
                right: 0;
                left: auto;
            }

            .dropdown-toggle {
                display: flex;
                align-items: center;
            }

            .dropdown-item {
                padding: 0.5rem 1rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .dropdown-item:hover {
                background-color: var(--color-primary);
                color: white;
            }

            .dropdown-item.text-danger:hover {
                background-color: #dc3545;
                color: white !important;
            }
        }

        .back-to-top {
            position: fixed;
            visibility: hidden;
            opacity: 0;
            right: 15px;
            bottom: 15px;
            z-index: 99999;
            background: #2c4964;  /* Koyu mavi ton */
            width: 40px;
            height: 40px;
            border-radius: 4px;
            transition: all 0.4s;
            text-decoration: none;
        }

        .back-to-top i {
            font-size: 24px;
            color: #fff;
            line-height: 0;
        }

        .back-to-top:hover {
            background: #3e5f8a;  /* Hover durumu için biraz daha açık ton */
            color: #fff;
            transform: translateY(-3px);  /* Hover'da hafif yukarı kalkma efekti */
            box-shadow: 0 4px 12px rgba(44, 73, 100, 0.15);  /* Hover'da gölge efekti */
        }

        .back-to-top.active {
            visibility: visible;
            opacity: 1;
        }
    </style>

    <!-- Preload Critical Assets -->
    <link rel="preload" href="{{ asset('assets/img/world-map.webp') }}" as="image" type="image/webp">
    <link rel="preload" href="{{ asset('assets/css/main.css') }}" as="style">
    <link rel="preload" href="{{ asset('assets/js/main.js') }}" as="script">
    <link rel="preload" href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" as="style">
    
    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    <!-- Vendor CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.css') }}">
    @yield('styles')
</head>
<body>
    @include('layouts.partials.header')
    
    @include('layouts.partials.search')
    
    <main id="main">
        @yield('content')
    </main>

    <footer>
        @include('layouts.partials.footer')
    </footer>

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
        crossorigin="anonymous" defer></script>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}" defer></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}" defer></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}" defer></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}" defer></script>
    @yield('scripts')

    <script>
        // Scroll to show/hide header
        let lastScrollTop = 0;
        const header = document.getElementById('header');
        const headerHeight = header.offsetHeight;
        let isScrolling;

        window.addEventListener('scroll', function() {
            clearTimeout(isScrolling);

            isScrolling = setTimeout(function() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                // Scroll aşağı
                if (scrollTop > lastScrollTop && scrollTop > headerHeight) {
                    header.style.transform = 'translateY(-100%)';
                    header.style.transition = 'transform 0.3s ease-in-out';
                } 
                // Scroll yukarı
                else {
                    header.style.transform = 'translateY(0)';
                    header.style.transition = 'transform 0.3s ease-in-out';
                }

                lastScrollTop = scrollTop;
            }, 10);
        });

        // Back to top button
        const backToTop = document.querySelector('.back-to-top');
        if (backToTop) {
            const toggleBacktotop = () => {
                if (window.scrollY > 100) {
                    backToTop.classList.add('active');
                } else {
                    backToTop.classList.remove('active');
                }
            };

            window.addEventListener('load', toggleBacktotop);
            window.addEventListener('scroll', toggleBacktotop);

            backToTop.addEventListener('click', (e) => {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
    </script>

</body>
</html> 