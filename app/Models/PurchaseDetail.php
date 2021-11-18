<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function purchase() {
        return $this->hasOne(Purchase::class, 'id', 'purchase_id');
    }

    public function product() {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }
}
