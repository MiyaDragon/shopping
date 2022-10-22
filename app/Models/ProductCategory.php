<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    use HasFactory;

    /**
     * 複数代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'order_no',
    ];

    /**
     * 商品の取得
     *
     * @return HasMany
     */
    public function product(): hasMany
    {
        return $this->hasMany(Product::class);
    }
}
