<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Basit CSS -->
    <style>
        .test-banner {
            background: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
        }
    </style>
</head>
<body>
    <!-- Test mesajı -->
    <div class="test-banner">
        Layout dosyası başarıyla yüklendi!
    </div>

    <div id="app">
        @yield('content')
    </div>
</body>
</html> 