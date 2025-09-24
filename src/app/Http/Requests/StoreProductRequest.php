<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // 権限チェックしない場合はtrueでOK
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'price' => ['required', 'integer', 'between:0,10000'],
            'season_ids' => ['required', 'array'],
            'season_ids.*' => ['exists:seasons,id'],
            'description' => ['required', 'string', 'max:120'],
            'image' => ['required', 'image', 'mimes:png,jpeg'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'price.integer' => '数値で入力してください',
            'price.between' => '0~10000円以内で入力してください',
            'season_ids.required' => '季節を選択してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
            'image.required' => '商品画像を登録してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
        ];
    }
}
