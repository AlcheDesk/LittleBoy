@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.TestSettings.menu')
  <testcase message="{{$message}}"></testcase>
@endsection