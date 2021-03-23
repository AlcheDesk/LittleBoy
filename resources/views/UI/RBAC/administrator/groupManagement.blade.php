@extends('UI.RBAC.menu')

@section('container')
  @parent
  <group-management message="{{$message}}"></group-management>

@endsection