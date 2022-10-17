<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_category_id',
        'name',
        'price',
        'description',
        'image_path',
    ];

    /**
     * 商品カテゴリの取得
     *
     * @return BelongsTo
     */
    public function productCategory(): BelongsTo
    {
        return $this->BelongsTo(ProductCategory::class);
    }
}
