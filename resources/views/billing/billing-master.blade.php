@extends('layouts.master')
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/south-street/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/plug-ins/725b2a2115b/integration/jqueryui/dataTables.jqueryui.css" rel="stylesheet" type="text/css" />
@section('content')

    <div class="content-wrapper">

    </div>

@endsection

@push('leftsidebar')
    @include('billing.billing-leftsidebar')
@endpush

@push('jscript')

    <script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.ui-contextmenu/1.7.0/jquery.ui-contextmenu.min.js"></script>

    <script src="{{ asset('jscript/billing.js?n='.$javs) }}"></script>

@endpush