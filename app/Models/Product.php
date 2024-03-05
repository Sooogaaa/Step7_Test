<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

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

    //Companiesモデルのデータを取得する
    public function company() {		
	    return $this->belongsTo(Company::class);
	}

    //一覧表示用のデータ取得
    public function findAllProducts($request, $searchproduct, $searchcompany) {
        $query = Company::query();

        //テーブル結合
        $query->join('products', function ($query) use ($request) {
            $query->on('products.company_id', '=', 'companies.id');
            });

        //$searchproductが空ではない場合、検索処理を実行
        if (!empty($searchproduct)) {
            $query->where('product_name', 'LIKE', "%{$searchproduct}%");
        }

        //$searchcompanyが空ではない場合、検索処理を実行
        if (!empty($searchcompany)) {
            $query->where('company_name', 'LIKE', $searchcompany);
        }
        
        return $query->orderBy('products.id', 'asc')->paginate(5);
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
        //リクエストデータを基に商品情報を登録する
        return $this->create([
            'company_id' => $request->company_id,
            'product_name' => $request->product_name,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->comment,
            'img_path' => $image_path
        ]);
    }

    //更新処理
    public function updateProduct($request, $id, $image_path) {
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

        return $result;
    }

    //削除処理
    public function deleteProductById($id) {
        return $this->destroy($id);
    }    
}
