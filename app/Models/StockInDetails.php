<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockInDetails extends Model
{
    use HasFactory;

    protected $fillable = ['stock_in_id', 'product_id', 'variant', 'sku', 'unit_price', 'qty'];

    public function StockIn(){
        return $this->belongsTo(StockIn::class);
    }
}
