@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.RunResult.menu')
  <project-runresult message="{{$message}}"></project-runresult>
@endsection