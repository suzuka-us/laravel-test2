<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // 商品一覧
    public function index(Request $request)
    {
        $query = Product::query();

        // 検索機能
        if ($request->has('keyword') && $request->keyword != '') {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // 並び替え機能
        if ($request->has('sort')) {
            if ($request->sort == 'price_desc') {
                $query->orderBy('price', 'desc');
            } elseif ($request->sort == 'price_asc') {
                $query->orderBy('price', 'asc');
            }
        }

        // ページネーション（6件ずつ）
        $products = $query->paginate(6)->withQueryString();

        return view('products.index', compact('products'));
    }

    // 商品詳細
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // 商品登録フォーム表示
    public function create()
    {
        return view('products.create');
    }

    // 新規商品登録
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|integer',
            'image' => 'required|string',
            'description' => 'required',
            'season' => 'nullable|string'
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', '商品を追加しました');
    }

    // 編集フォーム表示
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // 商品更新
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|integer',
            'image' => 'required|string',
            'description' => 'required',
            'season' => 'nullable|string'
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', '商品を更新しました');
    }

    // 商品削除
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', '商品を削除しました');
    }
}
