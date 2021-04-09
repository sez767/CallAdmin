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
    Рум - {{$extension}}

<script>
    var ext = <?= json_encode($extension, JSON_UNESCAPED_UNICODE) ?>
</script>
@endsection
