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

    <title>@yield('title', 'Admin Panel - ' . config('app.name'))</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 70px;
            --topbar-height: 60px;
            --sidebar-bg: #1a1a1a;
            --sidebar-hover: #2d2d2d;
        }

        body {
            min-height: 100vh;
        }

        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            background: var(--sidebar-bg);
            transition: all 0.3s;
        }

        #sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        #sidebar .nav-link {
            color: #fff;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
        }

        #sidebar .nav-link:hover {
            background: var(--sidebar-hover);
        }

        #sidebar .nav-link i {
            font-size: 1.2rem;
            min-width: 25px;
        }

        #sidebar .nav-link span {
            opacity: 1;
            transition: opacity 0.3s;
        }

        #sidebar.collapsed .nav-link span {
            opacity: 0;
            display: none;
        }

        #content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
            min-height: 100vh;
        }

        #content.expanded {
            margin-left: var(--sidebar-collapsed-width);
        }

        .sidebar-header {
            padding: 15px 20px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-header h3 {
            margin: 0;
            font-size: 1.2rem;
            white-space: nowrap;
        }

        #sidebar.collapsed .sidebar-header h3 {
            display: none;
        }

        @media (max-width: 768px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            #sidebar.active {
                margin-left: 0;
            }

            #content {
                margin-left: 0;
            }

            #content.expanded {
                margin-left: 0;
            }
        }

        /* Pagination Styles */
        .custom-pagination {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }

        .custom-pagination .pagination {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 0.25rem;
        }

        .custom-pagination .page-item .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 2rem;
            height: 2rem;
            padding: 0 0.5rem;
            font-size: 0.875rem;
            color: var(--sidebar-bg);
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
        }

        .custom-pagination .page-item.active .page-link {
            background-color: var(--sidebar-bg);
            border-color: var(--sidebar-bg);
            color: #fff;
        }

        .custom-pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
        }

        .custom-pagination .page-item .page-link:hover:not(.disabled) {
            background-color: var(--sidebar-hover);
            border-color: var(--sidebar-hover);
            color: #fff;
        }

        .custom-pagination .page-info {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .custom-pagination .page-link i {
            font-size: 0.75rem;
        }

        /* Pagination Component */
        .admin-pagination {
            margin-top: 2rem;
            padding: 1rem;
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .admin-pagination .pagination-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
        }

        .admin-pagination .pagination-nav {
            display: flex;
            gap: 0.5rem;
        }

        .admin-pagination .page-button {
            min-width: 2.5rem;
            height: 2.5rem;
            padding: 0 0.75rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            background: #fff;
            color: var(--sidebar-bg);
            font-size: 0.875rem;
            text-decoration: none;
            transition: all 0.2s;
        }

        .admin-pagination .page-button:hover {
            background: var(--sidebar-hover);
            color: #fff;
            border-color: var(--sidebar-hover);
        }

        .admin-pagination .page-button.active {
            background: var(--sidebar-bg);
            color: #fff;
            border-color: var(--sidebar-bg);
        }

        .admin-pagination .page-button.disabled {
            background: #f8f9fa;
            color: #6c757d;
            cursor: not-allowed;
            pointer-events: none;
        }

        .admin-pagination .page-info {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .admin-pagination .page-button i {
            font-size: 0.75rem;
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>Admin Panel</h3>
            <button class="btn btn-link text-light p-0 d-none d-md-block" id="sidebarCollapse">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.articles.index') }}" class="nav-link">
                    <i class="bi bi-file-text"></i>
                    <span>İçerikler</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-people"></i>
                    <span>Kullanıcılar</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-chat-dots"></i>
                    <span>Yorumlar</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-gear"></i>
                    <span>Ayarlar</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Content alanının üstünde -->
    @section('pagination')
    <div class="admin-pagination">
        <div class="pagination-wrapper">
            <div class="pagination-nav">
                <a href="#" class="page-button disabled">
                    <i class="bi bi-chevron-left"></i>
                </a>
                <a href="#" class="page-button active">1</a>
                <a href="#" class="page-button">2</a>
                <a href="#" class="page-button">3</a>
                <a href="#" class="page-button">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>
            <div class="page-info">
                1-10 / 20
            </div>
        </div>
    </div>
    @endsection

    <!-- Content area -->
    <div id="content">
        <!-- Top Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button class="btn btn-link d-md-none" id="sidebarCollapsePhone">
                    <i class="bi bi-list"></i>
                </button>
                
                <div class="ms-auto d-flex align-items-center">
                    <a href="{{ route('home') }}" class="btn btn-outline-primary me-3">
                        <i class="bi bi-house-door"></i> Siteye Dön
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle text-dark" type="button" id="userDropdown" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Profil</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Çıkış Yap</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <main class="p-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const sidebarCollapse = document.getElementById('sidebarCollapse');
            const sidebarCollapsePhone = document.getElementById('sidebarCollapsePhone');

            // Desktop toggle
            sidebarCollapse?.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('expanded');
            });

            // Mobile toggle
            sidebarCollapsePhone?.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickInsideToggle = sidebarCollapsePhone.contains(event.target);
                
                if (window.innerWidth <= 768 && !isClickInsideSidebar && !isClickInsideToggle) {
                    sidebar.classList.remove('active');
                }
            });
        });
    </script>

    @yield('scripts')
</body>
</html> 