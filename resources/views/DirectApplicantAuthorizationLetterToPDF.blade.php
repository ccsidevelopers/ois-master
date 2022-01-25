<html>
<head>
    <title></title>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <meta http-equiv="Content-Type" content="charset=utf-8" />
</head>
<style>
    button
    {
        visibility: hidden;
    }
    span
    {
        visibility: visible;
    }
    textarea
    {
        display: none;
    }
    .logoPDF[logo-type=false]
    {
        visibility: hidden;
    }
    .logoPDF[logo-type=true]
    {
        visibility: visible;
    }

    table
    {
        width: 100%;
    }

    table td
    {
        padding: 8px;
    }

    .pdfShow
    {
        visibility: visible;
    }

    .pdfHide
    {
        display: none;
    }

    .nextPageTrigger
    {
        page-break-after: always;
    }
    /*html{margin:40px 50px}*/

    @page {
       margin: 30px 80px 50px;
        page-break-after: always;
        font-size: 16px;
    }
    
</style>
<body>
<div class="row">
    {!! $content !!}
</div>
</body>
</html>