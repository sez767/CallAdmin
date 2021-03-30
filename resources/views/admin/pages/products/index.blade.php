@extends('admin.layouts.app', ['page' => __('Products'), 'pageSlug' => 'products'])

@section('scripts')
    <script src="{{ asset('js/products.js') }}" defer></script>
@stop
@section('css')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@stop

@section('content')
    <div id="products_page">
        <products></products>
    </div>
@endsection