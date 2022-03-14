<!doctype html>
<html lang="en">
<style>
 .greet{
     font-size: 20px;
 }
</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    {{--<title>Endorsements</title>--}}
</head>

<body>
<p><b>Highly Confidential: This message should not be distributed further without authorization of the sender.</b></p>
<br>
<p class="greet">Hi Sir/Ma'am,</p>

<ul class="list-group">
    <li class="list-group-item"><b>Account name: {{$account_name}}</b></li>
    <li class="list-group-item"><b>Type of Request: {{$tor}}</b></li>
    <li class="list-group-item"><b>Address: {{$address}}</b></li>
    <li class="list-group-item"><b>Date/Time Sent: {{$date_time}}</b></li>
    <li class="list-group-item"><b>Remarks: {{$remarks}}</b></li>
</ul>
<p class="greet">To download the report. Please click this link: {{$filepath}}</p>

    <p style="color: black"><b><i>PS: THIS IS GENERATED EMAIL FROM CCSI - Online Information Management System (OIMS).</i></b></p>
    <br>
    @if($name_ci == 'NONE')
    <p><b> Handler of the Account: </b></p>
    <p> Name: {{$name_ao}}<br>
        Position: Account Officer<br>
        Email: {{$email_ao}}
    </p>
    <p> Name: {{$name_sao}}<br>
        Position: Senior Account Officer<br>
        Email: {{$email_sao}}
    </p>
    @endif
    <br>
    <p>
        <b>Kind Regards,</b>
    </p>
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