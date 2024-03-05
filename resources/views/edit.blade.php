@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">商品情報編集画面</div>

                <div class="card-body">
					<form action="{{ route('update', ['id'=>$detail->id]) }}" method="POST" enctype='multipart/form-data'>
					@csrf
						<div class="row mb-3">
							<label class="col-md-4 col-form-label text-md-end">ID</label>
							<div class="col-md-6 col-form-label">{{$detail->id}}</div>
						</div>

						<div class="row mb-3">
							<label class="col-md-4 col-form-label text-md-end">商品名<span class="text-danger">*</span></label>
							<div class="col-md-6">
								<input type="text" name="product_name" class="form-control" value="{{ old('product_name', $detail->product_name) }}">
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-md-4 col-form-label text-md-end">メーカー名<span class="text-danger">*</span></label>
							<div class="col-md-6">
								<select name="company_id" class="form-control">
									@foreach ($companies_list as $companies_item)
										@if (!is_null(old('company_id')))
											<!--エラー時の再表示-->
											@if ($companies_item->id == old('company_id'))
												<option value="{{ $companies_item->id }}" selected>{{ $companies_item->company_name }}</option>
											@else
												<option value="{{ $companies_item->id }}">{{ $companies_item->company_name }}</option>
											@endif
										@else
											<!--初期表示-->
											@if ($companies_item->id == $detail->company_id)
												<option value="{{ $companies_item->id }}" selected>{{ $companies_item->company_name }}</option>
											@else
												<option value="{{ $companies_item->id }}">{{ $companies_item->company_name }}</option>
											@endif
										@endif
									@endforeach
								</select>
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-md-4 col-form-label text-md-end">価格<span class="text-danger">*</span></label>
							<div class="col-md-6">
								<input type="text" name="price" class="form-control" value="{{ old('price', $detail->price) }}">
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-md-4 col-form-label text-md-end">在庫数<span class="text-danger">*</span></label>
							<div class="col-md-6">
								<input type="text" name="stock" class="form-control" value="{{ old('stock', $detail->stock) }}">
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-md-4 col-form-label text-md-end">コメント</label>
							<div class="col-md-6">
								<textarea type="text" class="form-control" name="comment">{{ old('comment', $detail->comment) }}</textarea>
							</div>
						</div>
						
						<div class="row mb-3">
							<label class="col-md-4 col-form-label text-md-end">商品画像</label>
							<div class="col-md-6">
								<img src="{{ asset($detail->img_path) }}" width="100" height="100">
								<input type="file" name="image" class="form-control">
							</div>
						</div>
						
						<div class="row mb-0">
							<div class="col-md-6 offset-md-4">
								<input type="submit" class="btn btn-primary" value="更新" />
								<a class="btn btn-primary" href="{{ route('detail', ['id'=>$detail->id]) }}">戻る</a>
							</div>
						</div>

					</form>
				</div>
            </div>
        </div>
    </div>
</div>
@endsection
