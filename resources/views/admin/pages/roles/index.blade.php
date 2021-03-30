@extends('admin.layouts.app', ['page' => __('Roles'), 'pageSlug' => 'roles'])

@section('scripts')
    <script src="{{ asset('js/roles.js') }}" defer></script>
@stop
@section('css')
	<link href="{{ asset('css/form.css') }}" rel="stylesheet">
    <link href="{{ asset('css/roles.css') }}" rel="stylesheet">
@stop

@section('content')
    <div id="roles_page">
        <roles
            :edit_url="'{{ route('roles.edit', ['role' => 'default']) }}'"
        	:create_url="'{{ route('roles.create') }}'"
            :constant_roles="{{json_encode($constantRoles)}}"
            :constant_roles_warning="{{json_encode(\App\Models\Role::constantRoleWarning())}}"
        ></roles>
    </div>
@endsection