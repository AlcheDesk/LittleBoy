@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.TestSettings.menu')
  <run-list message="{{$message}}"></run-list>
@endsection