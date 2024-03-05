@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">商品情報登録画面</div>

                <div class="card-body">
					<form action="{{ route('store') }}" method="POST" enctype='multipart/form-data'>
						@csrf
						<div class="row mb-3">
							<label for="product_name" class="col-md-4 col-form-label text-md-end">商品名<span class="text-danger">*</span></label>
							<div class="col-md-6">
								<input type="text" name="product_name" class="form-control">
							</div>
						</div>
						
						<div class="row mb-3">
							<label for="company_id" class="col-md-4 col-form-label text-md-end">メーカー名<span class="text-danger">*</span></label>
							<div class="col-md-6">
								<select name="company_id" class="form-control">
									<option value="">メーカ名を選択</option>
							
									@foreach ($companies_list as $companies_item)
										<option value='{{$companies_item->id}}'>{{ $companies_item->company_name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						
						<div class="row mb-3">
							<label for="price" class="col-md-4 col-form-label text-md-end">価格<span class="text-danger">*</span></label>
							<div class="col-md-6">
								<input type="text" name="price" class="form-control">
							</div>
						</div>

						<div class="row mb-3">
							<label for="stock" class="col-md-4 col-form-label text-md-end">在庫数<span class="text-danger">*</span></label>
							<div class="col-md-6">
								<input type="text" name="stock" class="form-control">
							</div>
						</div>

						<div class="row mb-3">
							<label for="comment" class="col-md-4 col-form-label text-md-end">コメント</label>
							<div class="col-md-6">
								<textarea type="text" name="comment" class="form-control"></textarea>
							</div>
						</div>

						<div class="row mb-3">
							<label for="image" class="col-md-4 col-form-label text-md-end">商品画像</label>
							<div class="col-md-6">
								<input type="file" name="image" class="form-control">
							</div>
						</div>

						<div class="row mb-0">
							<div class="col-md-6 offset-md-4">
								<input type="submit" class="btn btn-primary" value="登録" />
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
