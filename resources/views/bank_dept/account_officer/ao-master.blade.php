@extends('layouts.master')

<style>

    #map_wrapper {
        height: 80%;
    }

    #map_canvas {
        width: 100%;
        height: 93%;
    }

    /*.info_content{*/
    /*width: 100%;*/
    /*height: 100%;*/
    /*margin-top: 9px;*/
    /*line-height:10px;*/
    /*}*/


</style>

@section('content')
    <div class="content-wrapper">



    </div>
@endsection

@push('leftsidebar')
    @include('bank_dept.account_officer.ao-leftsidebar')
@endpush

@push('jscript')

    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('jscript/ao.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/endorsement.js?n='.$javs) }}"></script>
    <script src="{{ asset('jscript/maps.js?n='.$javs) }}"></script>

@endpush