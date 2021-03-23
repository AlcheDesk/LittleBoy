@extends('UI.RBAC.menu')

@section('container')
  @parent
  <user-management message="{{$message}}"></user-management>

@endsection