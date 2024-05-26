<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use HasFactory;
    use Sortable;

    // モデルに関連付けるテーブル
    protected $table = 'products';

    // テーブルに関連付ける主キー
    protected $primaryKey = 'id';

    // 登録・更新可能なカラムの指定
    protected $fillable = [
        'id',
        'company_id',
        'product_name',
        'price',
		'stock',
		'comment',
		'img_path',
        'created_at',
        'updated_at'
    ];

    //ソートに使用するカラムの指定
    public $sortable = [
        'id',
        'product_name',
        'price',
		'stock'
    ];

    public $sortableAs = [
        'company_name'
    ];

    //Companiesモデルのデータを取得する
    public function company() {		
	    return $this->belongsTo(Company::class);
	}

    //一覧表示用のデータ取得
    public function findAllProducts($request) {
        //テーブル結合
        $query = Product::sortable()
            ->join('companies','company_id','=','companies.id')
            ->select('products.*','companies.company_name as company_name');
        
        return $query->orderBy('id', 'desc')->paginate(5);
    }

    public function SearchProducts($request, $sortfield, $sortorder, $searchproduct, $searchcompany, $lowprice, $highprice, $lowstock, $highstock) {
        //テーブル結合
        $query = Product::query()
            ->join('companies','company_id','=','companies.id')
            ->select('products.*','companies.company_name as company_name');
        
        //$searchproductが空ではない場合、検索処理を実行
        if (!empty($searchproduct)) {
            $query->where('product_name', 'LIKE', "%{$searchproduct}%");
        }

        //$searchcompanyが空ではない場合、検索処理を実行
        if (!empty($searchcompany)) {
            $query->where('company_name', 'LIKE', $searchcompany);
        }

        //$lowpriceが空ではない場合、検索処理を実行
        if (!empty($lowprice)) {
            $query->where('price', '>=', $lowprice);
        }

        //$highpriceが空ではない場合、検索処理を実行
        if (!empty($highprice)) {
            $query->where('price', '<=', $highprice);
        }

        //$lowstockが空ではない場合、検索処理を実行
        if (!empty($lowstock)) {
            $query->where('stock', '>=', $lowstock);
        }

        //$highstockが空ではない場合、検索処理を実行
        if (!empty($highstock)) {
            $query->where('stock', '<=', $highstock);
        }
        
        return $query->orderBy($sortfield, $sortorder)->paginate(5);
    }

    //リクエストされたIDをもとにProductsテーブルのレコードを1件取得
    public function findProductById($id) {
        return Product::find($id);
    }
    
    //プルダウン表示用にcompaniesテーブルから全ての情報を取得
    public function findAllCompanies() {
        return Company::all();
    }

    //登録処理
    public function InsertProduct($request, $image_path) {
        DB::beginTransaction();

        try{
            //リクエストデータを基に商品情報を登録する
            $result = $this->create([
                'company_id' => $request->company_id,
                'product_name' => $request->product_name,
                'price' => $request->price,
                'stock' => $request->stock,
                'comment' => $request->comment,
                'img_path' => $image_path
            ]);

            DB::commit();
            return $result;

        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }        
    }

    //更新処理
    public function updateProduct($request, $id, $image_path) {
        DB::beginTransaction();

        try{
            //更新対象のデータ取得
            $update = Product::find($id);

            //リクエストデータを基に商品情報を更新する
            $result = $update->fill([
                'company_id' => $request->company_id,
                'product_name' => $request->product_name,
                'price' => $request->price,
                'stock' => $request->stock,
                'comment' => $request->comment,
                'img_path' => $image_path
            ])->save();

            DB::commit();
            return $result;

        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }        
    }

    //削除処理
    public function deleteProductById($id) {
        DB::beginTransaction();

        try{
            $result = $this->destroy($id);
            DB::commit();
            return $result;

        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }        
    }    
}
