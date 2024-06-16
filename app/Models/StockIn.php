<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    protected $fillable = ['ref_no', 'vendor_id','warehouse_id','added_by', 'status','items'];

    public function StockInDetails(){
        return $this->hasMany(StockInDetails::class);
    }
}
