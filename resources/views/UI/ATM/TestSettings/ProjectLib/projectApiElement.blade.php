@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.TestSettings.menu')
  <project-apielement message="{{$message}}"></project-apielement>

@endsection