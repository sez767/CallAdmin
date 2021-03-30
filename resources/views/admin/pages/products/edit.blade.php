@extends('admin.layouts.app', ['page' => __('ProductsCr'), 'pageSlug' => 'productsCr'])

@section('css')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
    <link href="{{ asset('css/gallery.css') }}" rel="stylesheet">
    <link href="{{ asset('css/multiselect.css') }}" rel="stylesheet">
@stop

@section('scripts')
    <script src="{{ asset('js/productsCr.js') }}" defer></script>
@stop

@section('content')
    <div id="products_create">
        <products-create :edit="true" :prodid={{$id}}></products-create>
    </div>
@endsection