<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function sale_detail()
    {
        return $this->belongsTo(SaleDetail::class);
    }

    public function getRouteKeyName()
    {
        return 'invoice_no';
    }
}
