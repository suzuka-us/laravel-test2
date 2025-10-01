<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // 主キー
            $table->string('name', 255); // 商品名
            $table->integer('price'); // 価格
            $table->string('image', 255)->nullable(); // 画像パス
            $table->text('description'); // 商品説明
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
