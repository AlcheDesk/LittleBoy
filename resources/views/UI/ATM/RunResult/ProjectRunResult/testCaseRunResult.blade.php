@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.RunResult.menu')
  <project-testcase-runresult message="{{$message}}"></project-testcase-runresult>
@endsection