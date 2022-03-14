@extends('layouts.master')

@section('content')

    <div class="content-wrapper">

    </div>

@endsection

@push('leftsidebar')
    @include('general_user.general-user-leftsidebar')
@endpush

@push('jscript')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('jscript/general-attendance.js?n='.$javs) }}"></script>
@endpush
