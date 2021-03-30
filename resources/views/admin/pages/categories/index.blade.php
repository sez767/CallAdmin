@extends('admin.layouts.app', ['page' => __('Categories'), 'pageSlug' => 'categories'])

@section('scripts')
    <script src="{{ asset('js/categories.js') }}" defer></script>
@stop
@section('css')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@stop

@section('content')
    <div id="categories_page">
        <categories
        	:edit_url="'{{ route('categories.edit', ['category' => 'default']) }}'"
        	:create_url="'{{ route('categories.create') }}'"
        ></categories>
    </div>
@endsection