@extends('layouts.app')

@section('content')
<h1>{{ $product->name }}</h1>
<p>価格：{{ $product->price }}円</p>
<p>{{ $product->description }}</p>

@if($product->image)
    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="200">
@endif

<a href="{{ route('products.index') }}">一覧に戻る</a>
@endsection
