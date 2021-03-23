@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.TestSettings.menu')
  <folder-testcase message="{{$message}}"></folder-testcase>
@endsection