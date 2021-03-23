@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.TestSettings.menu')
  <project-testcase message="{{$message}}"></project-testcase>

@endsection