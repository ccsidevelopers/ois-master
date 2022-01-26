<html>
<head>
    <title></title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <meta http-equiv="Content-Type" content="charset=utf-8" />
</head>
<style>
    button
    {
        visibility: hidden;
    }
    table
    {
        border-collapse: collapse;
        border-style: solid;
    }
    table, td
    {
        border: 1px;
    }
    .centerContent
    {
        align-content: center;
        text-align: center;
    }
    input[type="checkbox"]
    {
        padding-left: 100px;
    }

    @page {
        margin: 30px 80px 50px;
        page-break-after: always;
        font-size: 16px;
    }

</style>
<body>
<div class="row">
    {!! $content !!}

    <!-- test commit comment -->
</div>
</body>
</html>