@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.TestSettings.menu')
  <application-section message="{{$message}}"></application-section>

@endsection