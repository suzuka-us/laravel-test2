<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // 商品一覧
    public function index()
    {
        $products = Product::with('seasons')->paginate(6);
        return view('products.index', compact('products'));
    }

    // 商品検索
    public function search(Request $request)
    {
        $query = Product::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', "%{$request->name}%");
        }

        // 並び替え
        if ($request->filled('sort')) {
            $query->orderBy('price', $request->sort);
        }

        $products = $query->with('seasons')->paginate(6);
        return view('products.index', compact('products'));
    }

    // 商品登録画面表示
    public function create()
    {
        $seasons = Season::all();
        return view('products.create', compact('seasons'));
    }

    // 商品登録
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        // 画像アップロード
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        $product = Product::create($data);
        $product->seasons()->sync($request->season_ids ?? []);

        return redirect('/products')->with('success', '商品を登録しました');
    }

    // 商品詳細
    public function show(Product $product)
    {
        $product->load('seasons');
        return view('products.show', compact('product'));
    }

    // 商品編集画面表示
    public function edit(Product $product)
    {
        $seasons = Season::all();
        $product->load('seasons');
        return view('products.edit', compact('product', 'seasons'));
    }

    // 商品更新
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // 古い画像を削除
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        $product->seasons()->sync($request->season_ids ?? []);

        return redirect('/products')->with('success', '商品を更新しました');
    }

    // 商品削除
    public function destroy(Product $product)
    {
        // 画像削除
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect('/products')->with('success', '商品を削除しました');
    }
}
