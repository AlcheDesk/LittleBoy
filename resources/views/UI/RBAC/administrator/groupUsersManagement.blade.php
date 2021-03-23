@extends('UI.RBAC.menu')

@section('container')
  @parent
  <group-user message="{{$message}}"></group-user>

@endsection