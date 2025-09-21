<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>商品一覧</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
</head>

<body>
  <header class="header">
    <div class="header__inner">
      <a class="header__logo" href="/">
        果物販売サイト
      </a>
    </div>
  </header>

  <main>
    <div class="product-list">
      <h2>商品一覧</h2>

      @foreach ($products as $product)
        <div class="product-card">
          <h3>{{ $product->name }}</h3>
          <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
          <p>{{ $product->description }}</p>
          <p>{{ $product->price }}円</p>
        </div>
      @endforeach

    </div>
  </main>
</body>

</html>
