@extends('admin.layouts.app', ['page' => __('Categories'), 'pageSlug' => 'categories'])

@section('scripts')
    <script src="{{ asset('js/categories.js') }}" defer></script>
@stop
@section('css')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@stop

@section('content')
    <div id="categories_page">
        <category-form
        	:index_url="'{{ route('categories.index') }}'"
        	:category_data="{{$category}}"
        ></category-form>
    </div>
@endsection