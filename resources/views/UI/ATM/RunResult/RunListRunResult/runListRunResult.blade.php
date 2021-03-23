@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.RunResult.menu')
  <runlist-runresult message="{{$message}}"></runlist-runresult>
@endsection