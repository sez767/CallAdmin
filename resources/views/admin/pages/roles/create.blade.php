@extends('admin.layouts.app', ['page' => __('Categories'), 'pageSlug' => 'categories'])

@section('scripts')
    <script src="{{ asset('js/roles.js') }}" defer></script>
@stop
@section('css')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@stop

@section('content')
    <div id="roles_page">
        <role-form :index_url="'{{ route('roles.index') }}'"></role-form>
    </div>
@endsection