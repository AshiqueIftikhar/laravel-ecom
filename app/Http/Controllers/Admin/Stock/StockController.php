<?php

namespace App\Http\Controllers\Admin\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(){
        $type = 'in_house';
        $products = 0;
        return view('admin-views.stock.list', compact('type', 'products'));
    }
}
