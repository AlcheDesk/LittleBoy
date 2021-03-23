@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.TestSettings.menu')
  <api-instruction message="{{$message}}"></api-instruction>

@endsection