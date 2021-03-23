@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.RunResult.menu')
  <testcase-run-runresult message="{{$message}}"></testcase-run-runresult>
@endsection