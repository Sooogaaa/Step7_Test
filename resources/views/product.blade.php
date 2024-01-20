@extends('layouts.app')

@section('content')
<div>
    <form action="{{ route('product') }}" method="GET">

    @csrf

    <input type="text" name="keyword">
    <input type="submit" value="検索">
  </form>
</div>

<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>商品画像</th>
      <th>商品名</th>
      <th>価格</th>
      <th>在庫数</th>
      <th>メーカー名</th>
      <th><a href="" class="btn btn-primary">新規作成</a></th>
    </tr>
  </thead>
  <tbody>
    @foreach ($products as $product)
    <tr>
      <td>{{ $product->id }}</td>
      <td>{{ $product->img_path }}</td>
      <td>{{ $product->product_name }}</td>
      <td>{{ $product->price }}</td>
      <td>{{ $product->stock }}</td>
      <td>{{ $product->company->company_name }}</td>
      <td><a href="" class="btn btn-primary">詳細</a></td>
      <td><a href="" class="btn btn-primary">削除</a></td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection