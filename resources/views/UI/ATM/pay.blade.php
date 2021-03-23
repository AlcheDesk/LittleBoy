@extends('layout.app')

@section('content')
<div class="col-md-6">
  <div class="card">
    <div class="card-header">支付宝支付</div>

    <div class="card-body">
        
        <form method="GET" action="{{ route('pay') }}">
        <div class="form-group row">
            <button type="submit" style="height: 50%;" class="btn btn-primary">{{ __('send') }}</button>
        </div>
        </form>
    </div>
  </div>
</div>
@endsection
