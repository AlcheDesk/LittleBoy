@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.TestSettings.menu')
  <testcase-instruction message="{{$message}}"></testcase-instruction>

@endsection