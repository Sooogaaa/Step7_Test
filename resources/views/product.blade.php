@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">商品一覧画面</div>

                <div class="card-body">
                    <!--検索機能-->                    
                    <form action="{{ route('product') }}" method="GET">
                        <div class="row mb-4">
                            @csrf
                            <div class="col-sm-3">
                                <!--商品名検索-->
                                <input type="text" class="form-control" placeholder="商品名を入力" name="searchproduct" 
                                value="{{ old('searchproduct', $searchproduct) }}">
                            </div>

                            <div class="col-sm-3">
                                <!--会社名検索-->
                                <select name="searchcompany" class="form-control">
                                    <option value="">メーカ名を選択</option>                                
                                    @foreach ($companies_list as $companies_item)
                                        <option>{{ $companies_item->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-3">
                                <input type="submit" class="btn btn-primary" value="検索">
                            </div>
                        </div>
                    </form>  
                    

                    <!--一覧表示-->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>商品画像</th>
                                <th>商品名</th>
                                <th>価格</th>
                                <th>在庫数</th>
                                <th>メーカー名</th>
                                <th><a href="{{ route('create') }}" class="btn btn-success">新規作成</a></th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td><img src="{{ asset($item->img_path) }}" width="100" height="100"></td>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->stock }}</td>
                                <td>{{ $item->company_name }}</td>
                                <td><a href="{{ route('detail', ['id' => $item->id]) }}" class="btn btn-primary">詳細</a></td>
                                <td>
                                    <form action="{{ route('destroy', ['id' => $item->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" onclick='return confirm("削除してもよろしいですか？")'>削除</button>
                                    </form></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $items->links('pagination::bootstrap-4') }}
                    </div>      
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
