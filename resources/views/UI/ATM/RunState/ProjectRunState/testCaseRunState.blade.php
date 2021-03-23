@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.RunState.menu')
  <testcase-runstatus message="{{$message}}"></testcase-runstatus>
@endsection