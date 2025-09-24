@extends('layouts.app')

@section('content')
<div>
    <h1>商品一覧</h1>

    <!-- 商品登録ボタン -->
    <div style="margin-bottom: 15px; text-align: right;">
        <a href="{{ route('products.create') }}" 
           style="background: #4CAF50; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none;">
            + 商品を追加
        </a>
    </div>

    <!-- 検索フォーム -->
    <form action="{{ route('products.search') }}" method="GET" style="margin-bottom: 15px;">
        <input type="text" name="name" placeholder="商品名で検索" value="{{ request('name') }}">
        <button type="submit">検索</button>

        <!-- 並び替え -->
        <select name="sort" onchange="this.form.submit()">
            <option value="">並び替え</option>
            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>値段が低い順</option>
            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>値段が高い順</option>
        </select>
    </form>

    <!-- 並び替えタグ表示 -->
    @if(request('sort'))
        <p>
            並び替え: 
            <span style="background:#eee; padding:2px 6px; border-radius:4px;">
                {{ request('sort') == 'asc' ? '値段が低い順' : '値段が高い順' }}
                <a href="{{ route('products.search', array_merge(request()->except('sort'))) }}">×</a>
            </span>
        </p>
    @endif

    <!-- 商品カード一覧 -->
    <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:20px; margin-top:20px;">
        @forelse($products as $product)
            <div style="border:1px solid #ddd; padding:10px; border-radius:8px;">
                <a href="{{ route('products.show', $product->id) }}">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width:100%; height:auto;">
                </a>
                <h3>{{ $product->name }}</h3>
                <p>価格: {{ number_format($product->price) }}円</p>
                <p>
                    季節:
                    @foreach($product->seasons as $season)
                        <span style="background:#f0f0f0; padding:2px 4px; margin:2px; border-radius:4px;">
                            {{ $season->name }}
                        </span>
                    @endforeach
                </p>
                <a href="{{ route('products.edit', $product->id) }}">編集</a> |
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('削除しますか？')">削除</button>
                </form>
            </div>
        @empty
            <p>商品が見つかりませんでした。</p>
        @endforelse
    </div>

    <!-- ページネーション -->
    <div style="margin-top:20px;">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>
@endsection
