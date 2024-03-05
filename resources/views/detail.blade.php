@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">商品情報詳細画面</div>

                <div class="card-body">
					<form action="" method="GET">
						<div class="row mb-3">
							<label class="col-md-4 col-form-label text-md-end">ID</label>
							<div class="col-md-6 col-form-label">{{$detail->id}}</div>
						</div>

						<div class="row mb-3">
							<label class="col-md-4 col-form-label text-md-end">商品画像</label>
							<div class="col-md-6 col-form-label"><img src="{{ asset($detail->img_path) }}" width="100" height="100"></div>
						</div>

						<div class="row mb-3">
							<label class="col-md-4 col-form-label text-md-end">商品名</label>
							<div class="col-md-6 col-form-label">{{$detail->product_name}}</div>
						</div>

						<div class="row mb-3">
							<label class="col-md-4 col-form-label text-md-end">メーカー名</label>
							<div class="col-md-6 col-form-label">{{$detail->company->company_name}}</div>
						</div>

						<div class="row mb-3">
							<label class="col-md-4 col-form-label text-md-end">価格</label>
							<div class="col-md-6 col-form-label">{{$detail->price}}</div>
						</div>

						<div class="row mb-3">
							<label class="col-md-4 col-form-label text-md-end">在庫数</label>
							<div class="col-md-6 col-form-label">{{$detail->stock}}</div>
						</div>
						
						<div class="row mb-3">
							<label class="col-md-4 col-form-label text-md-end">コメント</label>
							<div class="col-md-6 col-form-label">{{$detail->comment}}</div>
						</div>
						
						<div class="row mb-0">
							<div class="col-md-6 offset-md-4">
								<a class="btn btn-primary" href="{{ route('edit', ['id'=>$detail->id]) }}">編集</a>
								<a class="btn btn-primary" href="{{ route('product') }}">戻る</a>
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
@endsection
