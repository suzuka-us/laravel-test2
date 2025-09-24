@extends('layouts.app')

@section('content')
<div style="max-width:600px; margin:0 auto;">
    <h1>商品登録</h1>

    <!-- バリデーションエラー表示 -->
    @if ($errors->any())
        <div style="background:#ffe6e6; border:1px solid red; padding:10px; margin-bottom:20px; border-radius:8px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="color:red;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 登録フォーム -->
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 商品名 -->
        <div style="margin-bottom:15px;">
            <label for="name">商品名</label><br>
            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                   placeholder="商品名を入力" style="width:100%; padding:8px;">
        </div>

        <!-- 値段 -->
        <div style="margin-bottom:15px;">
            <label for="price">値段</label><br>
            <input type="number" name="price" id="price" value="{{ old('price') }}" 
                   placeholder="値段を入力" style="width:100%; padding:8px;">
        </div>

        <!-- 季節 -->
        <div style="margin-bottom:15px;">
            <label>季節</label><br>
            @foreach($seasons as $season)
                <label style="margin-right:10px;">
                    <input type="checkbox" name="season_ids[]" value="{{ $season->id }}"
                           {{ in_array($season->id, old('season_ids', [])) ? 'checked' : '' }}>
                    {{ $season->name }}
                </label>
            @endforeach
        </div>

        <!-- 商品説明 -->
        <div style="margin-bottom:15px;">
            <label for="description">商品説明</label><br>
            <textarea name="description" id="description" rows="4" 
                      placeholder="商品の説明を入力" style="width:100%; padding:8px;">{{ old('description') }}</textarea>
        </div>

        <!-- 商品画像 -->
        <div style="margin-bottom:15px;">
            <label for="image">商品画像</label><br>
            <input type="file" name="image" id="image" accept=".png,.jpeg">
        </div>

        <!-- ボタン -->
        <div style="margin-top:20px;">
            <button type="submit" 
                    style="background:#4CAF50; color:white; padding:10px 20px; border:none; border-radius:6px;">
                登録
            </button>
            <a href="{{ route('products.index') }}" 
               style="margin-left:10px; background:#ccc; padding:10px 20px; border-radius:6px; text-decoration:none; color:black;">
                戻る
            </a>
        </div>
    </form>
</div>
@endsection
