<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductIndexRequest extends FormRequest
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
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * クエリパラメータの取得（商品カテゴリ）
     *
     * @return string
     */
    public function category(): string
    {
        return $this->query('category', 'all');
    }

    /**
     * クエリパラメータの取得（名称）
     *
     * @return string
     */
    public function keyword(): string
    {
        return $this->query('keyword', '');
    }

    /**
     * クエリパラメータの取得（価格）
     *
     * @return string
     */
    public function price(): string
    {
        return $this->query('price', '');
    }

    /**
     * クエリパラメータの取得（価格）
     *
     * @return string
     */
    public function aboveBelow(): string
    {
        $query = $this->query('aboveBelow', 'over');

        $arrow = '>=';

        if($query == 'under') {
            $arrow = '<=';
        }

        return $arrow;
    }

    /**
     * クエリパラメータの取得（並び替え要素）
     *
     * @return string
     */
    public function element(): string
    {
        return $this->query('element', 'id');
    }

    /**
     * クエリパラメータの取得（並び替え方向）
     *
     * @return string
     */
    public function direction(): string
    {
        return $this->query('direction', 'asc');
    }

    /**
     * クエリパラメータの取得（表示項目数）
     *
     * @return string
     */
    public function count(): string
    {
        return $this->query('count', 10);
    }
}
