@extends('layouts.app')

@push('head-scripts')
    <link rel="stylesheet" type="text/css" href="{{ '/css/cyber_mega_phone.css' }}">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
    <script src="https://jssip.net/download/releases/jssip-3.4.2.js"></script>
@endpush
@section('content')
    <audio id="insounds" src="{{ asset('sounds/ringback.ogg') }}" type="audio/ogg" ></audio>
    <audio id="outsounds" src="{{ asset('sounds/ringing.ogg') }}" type="audio/ogg" ></audio>
<script>
    var accountRole = '';
    var operator = null;
    @isset($role)
        var accountRole = {!! json_encode($role) !!};
    @endisset
    @isset($name)
        var accountIdName = {!! json_encode($name) !!};
    @endisset
    @isset($pass)
        var accountPassword = {!! json_encode($pass) !!};
    @endisset
    @isset($operator)
        var operator = {!! json_encode($operator) !!};
    @endisset
    @isset($staffId)
        var staffId = {!! json_encode($staffId) !!};
    @endisset
    @isset($site)
        var clientSite = {!! json_encode($site) !!};
    @endisset
</script>
<script src="{{ 'js/call-numpad.js' }}"></script>
@endsection
