@extends('dashboard.layout')
@section('content')
@include('dashboard.commodity.commodity_breadcrumb')

<div class="row justify-content-center" id="app">
<edit-commodity commodity="{{ ($product) }}"></edit-commodity>
</div>

@endsection
@push('app_js')
    <script src="/js/app.js"></script>
@endpush
@push('app_css')
    <link rel="stylesheet" href="/css/app.css">
@endpush