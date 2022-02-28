
<html>
<head>
    <title>{{$forTitle}}</title>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <meta http-equiv="Content-Type" content="charset=utf-8" />
</head>
<style>
    button
    {
        visibility: hidden;
    }

    /*html{margin:40px 50px}*/

    @page {
       margin: 30px 80px 50px;
        page-break-after: always;
        font-size: 16px;
    }
    
    .newPageTrigger
    {
        page-break-before: always;
    }

    /*.dash{*/

        /*border: 0 none;*/
        /*border-bottom: 1px dotted #000;*/
        /*background: none;*/
        /*height:0;*/
        /*margin-bottom: -20px;*/
    /*}*/

    input
    {
        width : 100%;
        border-width:0;
        border:none;
        margin: 0;
        padding : 0;
        word-wrap: break-word;
    }
    textarea
    {
        width : 100%;
        /*border-width:0;*/
        /*border:none;*/
    }

    td
    {
        border-bottom: 0.1px black solid;
        border-top : none;
    }

    p
    {
        font-family: "Times New Roman", serif;
        text-transform: uppercase;
        font-size: 16px;
        padding : 0;
        margin: 0;
        text-align:  left;

        /*letter-spacing: 1.5px*/
    }
    input
    {
        font-family: "Times New Roman", serif;
        text-transform: uppercase;
        font-size: 16px;
        /*letter-spacing: 1.5px*/
    }

    .removeThisButtons
    {
        display: none;
    }

    table tr
    {
        border-top: none;
        border-bottom : none;

        /*line-height: 17px;*/
    }

    tr
    {
        border-top: none;
        border-bottom : none;
    }

    .select-hide-rows
    {
        visibility: hidden;
    }
    
</style>
<body>
<div class = "row">
    <div class = "col-md-12">
        <h2 class="pull-left" style="position: absolute; margin-left: 8%; padding-top: 13px;"><big>COMPREHENSIVE CREDIT SERVICES, INC.</big> <br><small>TELEVERIFIER ENCODED REPORT</small></h2>
        <img src="{{public_path('/dist/img/ccsi-icon.png')}}" width="80" height="80">
    </div>
</div>
<div class = "row" style = "padding-top : 10px;">
    <div class = "col-md-12">{!! $content !!}</div>
</div>
</body>
</html>