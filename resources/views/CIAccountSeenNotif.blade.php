<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

</head>
<body>
<p><b>Highly Confidential: This message should not be distributed further without authorization of the sender.</b></p>
<br>

<p>CI NAME: <b>{{Auth::user()->name}}</b></p>
<p>DATE/TIME SEEN: <b>{{$now}}</b></p>
<p>ACCOUNT SEEN:</p>
{{--<p>Here are the details of endorsement of CI <b>{{Auth::user()->name}}</b>:</p>--}}
<ul class="list-group">
    @for($ctr = 0; $ctr < $countLoop; $ctr++)
        <li class="list-group-item">Date/Time Endorse: {{ $bulkData[$ctr]->date_time_endorsed }}</li>
        <li class="list-group-item">Account Name: {{ $bulkData[$ctr]->account_name }}</li>
        <li class="list-group-item">Address: {{ $bulkData[$ctr]->address . ' ' . $bulkData[$ctr]->muni_name }}</li>
        {{--<li class="list-group-item">Name of Requestor: {{ $bulkData[$ctr]['NameReq'] }}</li>--}}
        {{--<li class="list-group-item">Type of Loan: {{ $bulkData[$ctr]['LoneType'] }}</li>--}}
        <li class="list-group-item">Type of Request: {{ $bulkData[$ctr]->type_of_request }}</li>
        <br>
        <br>
    @endfor
</ul>

<p style="color: black"><b><i>NOTE: THIS IS <u>GENERATED EMAIL</u> FROM CCSI - Online Information Managemement System (OIMS) PLEASE DO NOT REPLY TO THIS EMAIL. FOR ANY CLARIFICATION OR ISSUE
            REGARDING TO THIS, PLEASE EMAIL US HERE:</i></b></p>
<b>oims.support@ccsi.ph</b><br>

<p style="font-size: 20px; color: red; margin-bottom: -10px">
    <i>Comprehensive Credit Services, Inc. OIMS</i>
</p>
<img src="https://www.ccsi-oims.net/dist/img/ccsi-logo.png">
<br>
<br>
<b style="color: red">Address:</b> Unit 2504 Summmit One Tower, 530 Shaw Blvd., Mandaluyong City
<br>
<br>
<i>
    <b>Disclaimer:</b> This message (including any attachments) may contain confidential, proprietary, privileged and/or private information.
    The information is intended to be for the use of the individual or entity designated above. If you are not the intended recipient
    of this message, please notify the sender immediately, and delete the message and any attachments. Any disclosure, reproduction, distribution
    or other use of this message or any attachments by an individual or entity other than the intended recipient is prohibited.
</i>

</body>
</html>