@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.RunResult.menu')
  <runcase-runresult message="{{$message}}"></runcase-runresult>
@endsection