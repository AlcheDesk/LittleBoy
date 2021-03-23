@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.RunResult.menu')
  <api-instruction-result-log message="{{$message}}"></api-instruction-result-log>
@endsection