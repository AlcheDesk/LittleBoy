@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.TestSettings.menu')
  <section-element message="{{$message}}"></section-element>

@endsection