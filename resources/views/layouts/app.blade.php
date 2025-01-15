<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <!-- Alternatif PNG favicon için -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>@yield('title', config('app.name'))</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
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
        @media (max-width: 991px) {
            .navbar .mobile-dropdown-menu {
                display: none;
                background-color: rgba(255, 255, 255, 0.1);
                border: none;
                margin: 0;
                padding: 0.5rem 0;
                list-style: none;
            }
            
            .navbar .mobile-dropdown-menu.show {
                display: block;
            }
            
            .navbar .mobile-dropdown-menu .dropdown-item {
                color: #fff;
                padding: 0.5rem 1.5rem;
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            
            .navbar .mobile-dropdown-menu .dropdown-item:hover {
                background-color: rgba(255, 255, 255, 0.2);
            }

            .mobile-dropdown-toggle {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.5rem 1rem;
                color: #fff;
                text-decoration: none;
                position: relative;
                padding-right: 2rem;
            }

            .mobile-dropdown-toggle::after {
                content: "\F282";
                font-family: "bootstrap-icons";
                position: absolute;
                right: 1rem;
                transition: transform 0.2s ease-in-out;
            }

            .mobile-dropdown-toggle[aria-expanded="true"]::after {
                transform: rotate(180deg);
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
    </style>
</head>
<body>
    <header>
        @include('layouts.partials.header')
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        @include('layouts.partials.footer')
    </footer>

    <!-- Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
        crossorigin="anonymous"></script>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @yield('scripts')

    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });
    </script>
</body>
</html> 