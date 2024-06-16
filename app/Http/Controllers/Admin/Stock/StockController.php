<?php

namespace App\Http\Controllers\Admin\Stock;

use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Contracts\Repositories\VendorRepositoryInterface;
use App\Enums\ViewPaths\Admin\POS;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StockController extends Controller
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepo,
        private readonly CategoryRepositoryInterface $categoryRepo,
        private readonly VendorRepositoryInterface $vendorRepo,
    )
    {
    }

    public function index(?Request $request)
    {
        $type = 'in_house';
        //$products = 0;
        $categories = $this->categoryRepo->getListWhere(orderBy: ['id' => 'desc'], filters: ['position' => 0]);
        $sellers = $this->vendorRepo->getByStatusExcept(status: 'pending', relations: ['shop']);
        $searchValue = $request['searchValue'] ?? null;
        $products = $this->productRepo->getListWhere(
            orderBy: ['id' => 'desc'],
            searchValue: $request['searchValue'],
            filters: [
                //'added_by' => 'in_house',
                //'category_id' => $categoryId,
                'status' => 1,
            ],
            dataLimit: getWebConfig('pagination_limit'),
        );
        $cartItems = [
              "customerName" => "Walking Customer",
              "customerPhone" => "",
              "customerId" => 0,
              "countItem" => 0,
              "total" => 0,
              "subtotal" => 0,
              "taxCalculate" => 0,
              "totalTaxShow" => 0,
              "totalTax" => 0,
              "discountOnProduct" => 0,
              "productSubtotal" => 0,
              "cartItemValue" => [],
              "customerOnHold" => false,
              "couponDiscount" => 0,
              "extraDiscount" => 0,
        ];

        return view('admin-views.stock.list', compact('type', 'categories','sellers','products','searchValue','cartItems'));
    }
    public function getStockQuickView(Request $request): \Illuminate\Http\JsonResponse
    {
        $product = $this->productRepo->getFirstWhereWithCount(
            params:['id'=> $request['product_id']],
            withCount: ['reviews'],
            relations: ['brand','category','rating','tags'],

        );

        return response()->json([
            'success' => 1,
            'product'=> $product,
            'view' => view("admin-views.stock.partials._stock-quick-view", compact('product'))->render(),
        ]);
    }

    public function addStock(Request $request){

        $request->validate([
            "seller_id"=>"required",
            "warehouse_id"=>"required",
            "date-time"=>"required",
            'refNo'=>"required",
        ]);
            $requestData = $request->all();
        return response()->json([
            'data'=>$requestData,
        ]);
    }
}
