@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.TestSettings.menu')
  <run-list-testcase message="{{$message}}"></run-list-testcase>
@endsection