@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.RunState.menu')
  <runlist-testcase-runstatus message="{{$message}}"></runlist-testcase-runstatus>
@endsection