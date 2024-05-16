<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct() {
        $this->product = new Product();
    }
    
    //商品一覧画面
    public function product(Request $request) {        
        //メーカ名検索用プルダウンデータ取得
        $companies_list = $this->product->findAllCompanies();
        
        //一覧表示用データを取得
        $items =$this->product->findAllProducts($request);
        return view('product', compact('items', 'companies_list'));
    }

    //商品一覧画面検索
    public function search(Request $request) {        
        //検索フォームに入力された値を取得
        $searchproduct = $request->searchproduct;
        $searchcompany = $request->searchcompany;
        $lowprice = $request->lowprice;
        $highprice = $request->highprice;
        $lowstock = $request->lowstock;
        $highstock = $request->highstock;
                
        $items =$this->product->SearchProducts($request, $searchproduct, $searchcompany, $lowprice, $highprice, $lowstock, $highstock);
        return response()->json($items);
    }

    //商品情報登録画面表示
    public function create(Request $request) {
        //メーカ名入力用プルダウンデータ取得
        $companies_list = $this->product->findAllCompanies();
        
        return view('create', compact('companies_list'));
    }

    //商品新規登録処理
    public function store(Request $request) {
        //画像ファイルのファイルパス作成
        $image = $request->file('image');
        if (!empty($image)) {            
            $file_name = $image->getClientOriginalName();
            $image->storeAs('public/images', $file_name);
            $image_path = 'storage/images/' . $file_name;
        }else{
            $image_path = null;
        }

        $registerProduct = $this->product->InsertProduct($request, $image_path);
        return redirect()->route('create');
    }

    //商品情報詳細画面表示
    public function detail($id) {
        $detail = $this->product->findProductById($id);
        return view('detail', compact('detail'));
    }

    //商品情報編集画面表示
    public function edit($id) {
        $detail = $this->product->findProductById($id);

        //メーカ名入力用プルダウンデータ取得
        $companies_list = $this->product->findAllCompanies();
        
        return view('edit', compact('detail', 'companies_list'));
    }

    //商品情報編集処理
    public function update(Request $request, $id) {
        //画像ファイルのファイルパス作成
        $image = $request->file('image');
        if (!empty($image)) {            
            $file_name = $image->getClientOriginalName();
            $image->storeAs('public/images', $file_name);
            $image_path = 'storage/images/' . $file_name;
        }else{
            $image_path = null;
        }

        $updateProduct = $this->product->updateProduct($request, $id, $image_path);
        return redirect()->route('edit', ['id'=> $id]);
    }

    //商品情報削除処理
    public function destroy(Request $request) {
        $id = $request->id;
        $deleteProduct = $this->product->deleteProductById($id);
    }
}
