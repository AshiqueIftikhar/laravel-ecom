<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock_In_Details extends Model
{
    use HasFactory;

    protected $table ='stock_in_details';
    protected $fillable = ['stock_in_id', 'product_id', 'variant', 'sku', 'unit_price', 'qty'];

    public function Stock_In(){
        return $this->belongsTo(Stock_In::class);
    }
}
