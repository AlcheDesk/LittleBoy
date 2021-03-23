@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.RunResult.menu')
  <testcase-runresult message="{{$message}}"></testcase-runresult>
@endsection