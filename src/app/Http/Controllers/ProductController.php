<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Season;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 商品一覧
    public function index()
    {
        $products = Product::with('seasons')->get(); // 季節も取得
        return view('products.index', compact('products'));
    }

    // 商品詳細
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // 登録画面表示
    public function create()
    {
        $seasons = Season::all();
        return view('products.create', compact('seasons'));
    }

    // 商品登録
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'],
            'image' => $data['image'],
        ]);

        if (isset($data['season_ids'])) {
            $product->seasons()->sync($data['season_ids']);
        }

        return redirect()->route('products.index')->with('success', '商品を登録しました');
    }

    // 編集画面表示
    public function edit(Product $product)
    {
        $seasons = Season::all();
        return view('products.edit', compact('product', 'seasons'));
    }

    // 商品更新
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required', 'integer', 'between:0,10000'],
            'description' => ['required', 'string', 'max:120'],
            'season_ids' => ['required', 'array'],
            'season_ids.*' => ['exists:seasons,id'],
            'image' => ['nullable', 'image', 'mimes:png,jpeg'],
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        $product->seasons()->sync($data['season_ids']);

        return redirect()->route('products.index')->with('success', '商品を更新しました');
    }

    // 商品削除
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->seasons()->detach();
        $product->delete();

        return redirect()->route('products.index')->with('success', '商品を削除しました');
    }

    // 検索
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $products = Product::where('name', 'like', "%{$keyword}%")->get();

        return view('products.index', compact('products'));
    }
}
