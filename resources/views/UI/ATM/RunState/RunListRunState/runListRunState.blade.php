@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.RunState.menu')
  <runlist-runstatus message="{{$message}}"></runlist-runstatus>
@endsection