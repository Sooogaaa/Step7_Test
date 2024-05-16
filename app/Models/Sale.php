<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    use HasFactory;

    // モデルに関連付けるテーブル
    protected $table = 'sales';

    // テーブルに関連付ける主キー
    protected $primaryKey = 'id';

    // 登録・更新可能なカラムの指定
    protected $fillable = [
        'id',
        'product_id',
        'created_at',
        'updated_at'
    ];

    //Productモデルのデータを取得する
    public function product() {		
	    return $this->belongsTo(Product::class);
	}

    //登録処理
    public function InsertSale($product, $product_id, $quantity) {
        DB::beginTransaction();

        try{
            // 在庫を減少させる
            $product->stock -= $quantity;
            $product->save();

            //リクエストデータを基に商品購入情報を登録する
            $result = $this->create([
                'product_id' => $product_id
            ]);

            DB::commit(); 
            return $result;                 

        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }        
    }
}
