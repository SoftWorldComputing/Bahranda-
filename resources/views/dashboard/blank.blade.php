@extends('dashboard.layout')
@section('content')

@can('view dashboard')
    Dashboard content
@endcan

@cannot('view dashboard')
    Other realated content
@endcannot
  

@endsection