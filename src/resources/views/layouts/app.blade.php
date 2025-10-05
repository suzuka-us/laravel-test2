<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '商品管理')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header style="background:#f5f5f5; padding:10px;">
        <h1>商品管理システム</h1>
        <nav>
            <a href="{{ route('products.index') }}">商品一覧</a> |
            <a href="{{ route('products.create') }}">商品登録</a>
        </nav>
    </header>

    <main style="padding:20px;">
        @yield('content')
    </main>

    <footer style="background:#f5f5f5; padding:10px; text-align:center;">
        <p>© 2025 商品管理システム</p>
    </footer>
</body>
</html>
