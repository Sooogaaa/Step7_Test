<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function __construct() {
        $this->sale = new Sale();
    }

    //商品購入情報登録処理
    public function purchase(Request $request) {
        DB::beginTransaction();

        try{
            // リクエストから必要なデータを取得する
            $product_id = $request->input('product_id');
            $quantity = $request->input('quantity', 1);

            // データベースから対象の商品を検索・取得
            $product = Product::find($product_id);

            // 商品が存在しない、または在庫が不足している場合のメッセージ表示
            if (!$product) {
                return response()->json(['message' => '商品が存在しません']);
            }
            if ($product->stock == 0) {
                return response()->json(['message' => '商品が在庫不足です']);
            }
            
            $registerSale = $this->sale->InsertSale($product, $product_id, $quantity);
            
            DB::commit(); 
            return response()->json(['message' => '購入成功']);            

        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }        
    }    
}
