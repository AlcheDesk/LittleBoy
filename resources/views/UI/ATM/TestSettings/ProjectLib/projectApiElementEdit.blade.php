@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.TestSettings.menu')
  <apielement-edit message="{{$message}}"></apielement-edit>

@endsection