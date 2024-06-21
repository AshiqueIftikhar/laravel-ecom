<?php

namespace App\Http\Controllers\Admin\Stock;

use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Contracts\Repositories\VendorRepositoryInterface;
use App\Enums\ViewPaths\Admin\POS;
use App\Http\Controllers\Controller;
use App\Models\Stock_In;
use App\Models\Stock_In_Details;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
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

    public function index(?Request $request){

        $stocks = Stock_In::with('shop')->orderBy('id','desc')->get();
//      dd($stocks);
        return view('admin-views.stock.list',compact('stocks'));
    }
    public function addNew(?Request $request)
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

        return view('admin-views.stock.add-new', compact('type', 'categories','sellers','products','searchValue','cartItems'));
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
    public function addStock(Request $request):RedirectResponse{

            $validated =  $request->validate([
                "seller_id"=>"required",
                "warehouse_id"=>"required",
                "date_time"=>"required",
                "refNo"=>"required",
                "items"=>"required",
        ]);
        //Save StockIn
            $fieldData = Stock_In::create([
                'vendor_id'=>$validated['seller_id'],
                'warehouse_id'=>$validated['warehouse_id'],
                'date_time'=>$validated['date_time'],
                'ref_no'=>$validated['refNo'],
                'status'=>'pending',
            ]);

//        Save StockInDetails
//        $items=[];
//        foreach($validated['items'] as $item ){
//           array_push($items, $item['productCode']);
//        }

            foreach($validated['items'] as $item ){
                Stock_In_Details::create([
                    'stock_in_id'=>$fieldData->id,
                    'product_id'=>$item['productCode'],
                    'variant'=>$item['productVariation'],
                    'sku'=>$item['productCode'],
                    'unit_price'=>$item['productUnitPrice'],
                    'qty'=>$item['productQty'],
                ]);
            }
//        return redirect()->action([StockController::class, 'index']);
//        $requestData = $request->all();
//            return response()->json([
//            'data'=>$requestData,
//        ]);
            Toastr::success(translate('Stock_added_successfully'));
            return redirect()->route('admin.stock.list');

    }



}
