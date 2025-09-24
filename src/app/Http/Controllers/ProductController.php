
namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest; // バリデーション用
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // 商品登録処理
    public function store(StoreProductRequest $request)
    {
        // バリデーション済みデータを取得
        $data = $request->validated();

        // 画像アップロード処理
        if ($request->hasFile('image')) {
            // storage/app/public/products に保存
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // 商品をDBに保存
        $product = Product::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'],
            'image' => $data['image'],
        ]);

        // 季節の関連付け (中間テーブルへ保存)
        if (isset($data['season_ids'])) {
            $product->seasons()->sync($data['season_ids']);
        }

        // 一覧画面へリダイレクト
        return redirect()->route('products.index')->with('success', '商品を登録しました');
    }
}
