@extends('layouts.master')

@section('content')

    <div class="content-wrapper">

    </div>

@endsection

@push('leftsidebar')
    @include('quality_analyst.qa-leftsidebar')
@endpush

@push('jscript')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('jscript/qa.js?n='.$javs) }}"></script>
    @if(Auth::user()->authrequest == 'All Access')
        <script src="{{ asset('jscript/endorsement-management.js?n='.$javs) }}"></script>
        <script src="{{ asset('jscript/bi-download-file-view-info.js?n='.$javs) }}"></script>
    @elseif(Auth::user()->authrequest == 'Bank Only')
        <script src="{{ asset('jscript/endorsement-management.js?n='.$javs) }}"></script>
    @elseif(Auth::user()->authrequest == 'CC Only')
        <script src="{{ asset('jscript/bi-download-file-view-info.js?n='.$javs) }}"></script>
    @endif
@endpush