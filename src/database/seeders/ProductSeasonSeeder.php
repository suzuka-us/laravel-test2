<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Season;

class ProductSeasonSeeder extends Seeder
{
    public function run(): void
    
    {
        // 全ての季節を取得
        $seasons = Season::all();


        // 全ての商品に対してランダムに季節を割り当てる
        Product::all()->each(function ($product) use ($seasons) {
            // 1〜4個の季節をランダムに選択
            $assignedSeasons = $seasons->random(rand(1, 4))->pluck('id')->toArray();

            // 中間テーブルに保存
            $product->seasons()->sync($assignedSeasons);
        });
    }
}

