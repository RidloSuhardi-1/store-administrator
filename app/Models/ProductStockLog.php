<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStockLog extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function product_stock()
    {
        return $this->belongsTo(ProductStock::class);
    }
}
