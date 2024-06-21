<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stock_In extends Model
{
    use HasFactory;

    protected $table = 'stock_ins';
    protected $fillable = ['ref_no','date_time', 'vendor_id','warehouse_id', 'status', 'grand_total', 'notes','added_by'];

    public function stockInDetails():HasMany{
        return $this->hasMany(Stock_In_Details::class);
    }
    public function shop(){
        return $this->belongsTo(shop::class,'vendor_id');
    }
}
