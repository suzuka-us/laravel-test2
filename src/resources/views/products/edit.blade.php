<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('POST') {{-- updateルートがPOST指定ならPOSTのままでOK。PUT/PATCHなら @method('PUT') --}}

    <!-- 商品名 -->
    <div>
        <label for="name">商品名</label>
        <input type="text" name="name" value="{{ old('name', $product->name) }}">
        @error('name')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <!-- 値段 -->
    <div>
        <label for="price">値段</label>
        <input type="number" name="price" value="{{ old('price', $product->price) }}">
        @error('price')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <!-- 季節 -->
    <div>
        <label>季節</label><br>
        @foreach($seasons as $season)
            <label>
                <input type="checkbox" name="season_ids[]" value="{{ $season->id }}"
                    {{ in_array($season->id, old('season_ids', $product->seasons->pluck('id')->toArray())) ? 'checked' : '' }}>
                {{ $season->name }}
            </label>
        @endforeach
        @error('season_ids')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <!-- 商品説明 -->
    <div>
        <label for="description">商品説明</label>
        <textarea name="description">{{ old('description', $product->description) }}</textarea>
        @error('description')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <!-- 商品画像 -->
    <div>
        <label for="image">商品画像</label>
        <input type="file" name="image">
        @if($product->image)
            <p>現在の画像：</p>
            <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像" width="120">
        @endif
        @error('image')
            <p style="color:red;">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit">変更を保存</button>
</form>
