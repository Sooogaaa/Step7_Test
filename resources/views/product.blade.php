@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">商品一覧画面</div>

                <div class="card-body">
                    <!--検索機能-->                    
                    <div class="row mb-4">
                        @csrf
                        <!--商品名検索-->
                        <div class="col-sm-3">                                                                
                            <input type="text" class="form-control" placeholder="商品名検索" name="searchproduct"  id = "searchproduct"
                            value="">
                        </div>
                        
                        <!--会社名検索-->
                        <div class="col-sm-3">                                
                            <select name="searchcompany" id = "searchcompany" class="form-control">
                                <option value="">メーカ名検索</option>                                
                                @foreach ($companies_list as $companies_item)
                                    <option>{{ $companies_item->company_name }}</option>
                                @endforeach
                            </select>
                        </div>                            
                    </div>

                    <div class="row mb-4">
                        <!--価格検索-->
                        <div class="col-sm-2">                                
                            <input type="text" class="form-control" placeholder="価格検索" name="lowprice" id = "lowprice"
                            value="">                                                              
                        </div>
                        ～ 
                        <div class="col-sm-2">                                     
                            <input type="text" class="form-control" placeholder="価格検索" name="highprice" id="highprice"
                            value="">
                        </div>

                        <!--在庫数検索-->
                        <div class="col-sm-2">                               
                            <input type="text" class="form-control" placeholder="在庫数検索" name="lowstock" id="lowstock"
                            value="">                                                             
                        </div>
                        ～ 
                        <div class="col-sm-2">     
                            <input type="text" class="form-control" placeholder="在庫数検索" name="highstock" id="highstock"
                            value="">                            
                        </div>

                        <div class="col-sm-3">
                            <input type="button" id="search-button" class="btn btn-info" value="検索">
                        </div>
                    </div>
                    
                    <!--一覧表示-->
                    <table class="table">
                        <thead>
                            <tr>
                            <th><a href="#" class="sortable" data-field="id" data-order="desc">ID</a></th>
                                <th>商品画像</th>
                                <th><a href="#" class="sortable" data-field="product_name" data-order="desc">商品名</a></th>
                                <th><a href="#" class="sortable" data-field="price" data-order="desc">価格</a></th>
                                <th><a href="#" class="sortable" data-field="stock" data-order="desc">在庫数</a></th>
                                <th><a href="#" class="sortable" data-field="company_name" data-order="desc">メーカー名</a></th>
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
                                <td><a data-delete_id="{{$item->id}}" class="btn btn-danger">削除</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $items->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>      
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    $(function() {
        // 削除処理の初期読み込み
        deleteProduct();

        // ソートリンクのクリックイベント
        $('.sortable').on('click', function(e) {
            e.preventDefault();
            const sortField = $(this).data('field');
            const sortOrder = $(this).data('order');
            const newOrder = sortOrder === 'asc' ? 'desc' : 'asc';
            $(this).data('order', newOrder);
            searchItems(sortField, newOrder);
        });

        // 検索ボタンのクリックイベント
        $('#search-button').on('click', function() {
            searchItems();
        });
    }); 

    //一覧検索処理(非同期)
    function searchItems(sortField = 'id', sortOrder = 'desc') {
        let searchProduct = $('#searchproduct').val();
        let searchCompany = $('#searchcompany').val();
        let lowPrice = $('#lowprice').val();
        let highPrice = $('#highprice').val();
        let lowStock = $('#lowstock').val();
        let highStock = $('#highstock').val();
        
        $.ajax({
            type: 'GET',
            url: '/Step7_Test/public/search',
            dataType: 'json',
            data: {
                'sort': sortField,
                'order': sortOrder,
                'searchproduct':searchProduct,
                'searchcompany':searchCompany,
                'lowprice':lowPrice,
                'highprice':highPrice,
                'lowstock':lowStock,
                'highstock':highStock,
            }
        })

        .done(function(response) {
            $('.table tbody').empty();
            let html = '';
            console.log(response);
            $.each(response.data, function (index, item) {
                let id = item.id;
                let img_path = decodeURIComponent(item.img_path);
                let product_name = item.product_name;
                let price = item.price;
                let stock = item.stock;
                let company_name = item.company_name;

                html += 
                    `  
                    <tr>
                        <td>${id}</td>
                        <td><img src="${img_path}" width="100" height="100"></td>
                        <td>${product_name}</td>
                        <td>${price}</td>
                        <td>${stock}</td>
                        <td>${company_name}</td>
                        <td><a href="detail/${id}" class="btn btn-primary">詳細</a></td>
                        <td><a data-delete_id="${id}" class="btn btn-danger">削除</a></td>
                    </tr>                            
                    `
            })
            $('.table tbody').append(html);

            //削除処理呼び出し
            deleteProduct();
        })

        .fail(function() {
                alert('エラー');
        });
    };

    //削除処理(非同期)
    function deleteProduct(){
        $('.btn-danger').on('click', function() {
        var deleteConfirm = confirm('削除してよろしいでしょうか？');

            if(deleteConfirm == true) {
                var clickEle = $(this)
                var delete_id = clickEle.attr('data-delete_id');
                $.ajax({
                    type: 'POST',
                    url: '/Step7_Test/public/destroy/'+ delete_id,
                    dataType: 'text',
                    data: {'id':delete_id},
                })

                .done(function() {                    
                    clickEle.parents('tr').hide();
                })

                .fail(function() {
                    alert('エラー');
                });                
            }
        });
    }

</script>

@endsection
