@extends('layouts.app')
@section('content')
<div class="row container">
    <div class="col-md-12">
        @include('common.errors')
        <form action="{{ url('wants/update') }}" method="POST">

            <!-- want_name -->
            <div class="form-group">
                <label for="want_name">商品名</label>
                <input type="text" name="want_name" class="form-control" value="{{$want->want_name}}">
            </div>
            <!-- /want_name -->

            <!-- want_amount -->
            <div class="form-group">
                <label for="want_amount">Amount</label>
                <input type="text" name="want_amount" class="form-control" value="{{$want->want_amount}}">
            </div>
            <!--/ want_amount -->

            <!-- Saveボタン/Backボタン -->
            <div class="wel wel-sm">
                <button type="submit" class="btn btn-primary">Save</button>
                <a class="btn btn-link pull-right" href="{{ url('/') }}">
                    Back
                </a>
            </div>
            <!--/ Saveボタン/Backボタン -->

            <!-- id値を送信 -->
            <input type="hidden" name="id" value="{{$want->id}}">
            <!--/ id値を送信 -->

            <!-- CSRF -->
            @csrf
            <!--/ CSRF -->

        </form>
    </div>
</div>
@endsection