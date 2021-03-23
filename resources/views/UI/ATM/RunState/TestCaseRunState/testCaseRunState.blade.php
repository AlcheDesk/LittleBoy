@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.RunState.menu')
  <testcase-run-runstatus message="{{$message}}"></testcase-run-runstatus>
@endsection