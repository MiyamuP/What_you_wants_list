<!-- resources/views/books.blade.php -->
@extends('layouts.app')
@section('content')
<!--Bootstrapの定形コード⋯ -->
<div class="card-body">
    <h1 class="card-title">
        欲しい物リスト
    </h1>
    <br>
    <h2 class="card-title">
        欲しいもの登録フォーム
    </h2>
    <!--バリデーションエラーの表示に使用-->
    @include('common.errors')
    <!--バリデーションエラーの表示に使用-->
    <!--欲しいもの登録フォーム-->
    <form enctype="multipart/form-data" action="{{ url('wants') }}" method="POST" class="form-horizontal">
        @csrf
        <!--欲しいもの名前-->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="want" class="col-sm-3 control-label">商品名</label>
                <input type="text" name="want_name" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label for="amount" class="col-sm-3 control-label">金額</label>
                <input type="text" name="want_amount" class="form-control">
            </div>
        </div>

        <!-- file追加 -->
        <div class="col-sm-6">
            <label>画像</label>
            <input type="file" name="want_image">
        </div>

        <!--欲しいもの登録ボタン-->
        <div class="form-row">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-primary">
                    Save
                </button>
            </div>
        </div>
    </form>
</div>
@if(session('message'))
<div class="alert alert-success">
    {{ session('message') }}
</div>
@endif
@php
$sum=0;
foreach($wants as $want) {
$sum += $want->want_amount;
}
$month = $sum/$target_amount;
@endphp

<!-- 目標表示 -->
<h2>{{"月目標貯金額:". $target_amount."円、全て購入できるまで".$month."ヶ月" }}</h2>

<!--Book:既に登録されてる欲しいもののリスト-->
<!-- 現在の欲しいもの -->
@if (count($wants) > 0)
<div class="card-body">
    <div class="card-body">
        <table class="table table-striped task-table">
            <!-- テーブルヘッダ -->
            <thread>
                <th>欲しいもの一覧</th>
                <th></th>
                <th></th>
                <th>&nbsp;</th>
            </thread>
            <!-- テーブル本体 -->
            <tbody>
                <tr>
                    <th>商品名</th>
                    <th>金額</th>
                    <td></td>
                    <td></td>
                </tr>
                @foreach ($wants as $want)
                <tr>
                    <!-- 商品名 -->
                    <td class="table-text">
                        <div>{{ $want->want_name }}</div>
                        <div><img src="upload/{{$want->want_image}}" width="100"></div>
                    </td>

                    <!-- 金額 -->
                    <td class="table-text">
                        <div>{{ $want->want_amount }}</div>
                    </td>

                    <!-- 欲しいもの：更新ボタン -->
                    <td>
                        <form action="{{ url('wantsedit/'.$want->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                更新
                            </button>
                        </form>
                    </td>

                    <!-- 欲しいもの：消去ボタン -->
                    <td>
                        <form action="{{ url('want/'.$want->id) }}" method="POST">
                            @csrf
                            <!-- CSRFからの保護 -->
                            @method('DELETE')
                            <!-- 擬似フォームメソッド -->

                            <button type="submit" class="btn btn-danger">
                                削除
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-4 offset-md-4">
        {{ $wants->links() }}
    </div>
</div>
@endif
@endsection