<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stock_In extends Model
{
    use HasFactory;

    protected $table = 'stock_ins';
    protected $fillable = ['ref_no', 'vendor_id','warehouse_id','added_by', 'status','items'];

    public function Stock_In_Details():HasMany{
        return $this->hasMany(Stock_In_Details::class);
    }
    public function seller(){
        return $this->belongsTo(Seller::class,);
    }
}
