@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.RunResult.menu')
  <project-charts message="{{$message}}"></project-charts>
@endsection