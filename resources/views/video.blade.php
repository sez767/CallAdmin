@extends('layouts.app')

@push('head-scripts')
    <link rel="stylesheet" type="text/css" href="{{ '/css/cyber_mega_phone.css' }}">
    <script src="{{ '/js/sdp-interop-sl-1.4.0.js' }}"></script>
    <script src="{{ '/js/jssip-3.0.13.js' }}"></script>
    <script src="{{ '/js/utils.js' }}"></script>
    <script src="{{ '/js/cyber_mega_phone.js' }}"></script>
    <script src="{{ '/js/cyber_video.js' }}" ></script>

@endpush

@section('content')


<script>
    var accountRole = '';
    @isset($role)
        var accountRole = {!! json_encode($role) !!};
    @endisset
    @isset($name)
        var accountIdName = {!! json_encode($name) !!};
    @endisset
    @isset($pass)
        var accountPassword = {!! json_encode($pass) !!};
    @endisset
    @isset($extention)
        var extension = {!! json_encode($extention) !!};
    @endisset 
</script>
@endsection
