@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.TestSettings.menu')
  <project-application message="{{$message}}"></project-application>

@endsection