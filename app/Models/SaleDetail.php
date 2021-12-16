<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function sale() {
        return $this->hasOne(Sale::class, 'id', 'sale_id');
    }

    public function product() {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }
}
