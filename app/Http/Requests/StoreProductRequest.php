<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'product_category_id' => 'required|numeric',
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable',
            'image_path' => 'nullable|file',
        ];
    }

    /**
     * バリデーションエラーのカスタム属性の取得
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'productCategory' => '商品カテゴリ',
            'name' => '名称',
            'price' => '価格',
            'image_path' => 'イメージ',
        ];
    }
}
