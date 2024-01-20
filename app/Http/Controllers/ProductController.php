<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        //productsテーブルの内容を全取得
        $products = Product::all();

        //キーワード検索処理
        $keyword = $request->input('keyword');
        //$keywordが空ではない場合、検索処理を実行
        if(!empty($keyword)) {
            $products = Product::where('product_name', 'LIKE', "%{$keyword}%")->get();
        }

        return view('product', [
            'products' => $products,
        ]);


        //productsテーブルのcompany_idと一致するcompany_nameをcompaniesテーブルから取得
	    $products = product::with('company:company_name');

        return view('product', [
            'products' => $products,
        ]);
        
    }    
}
