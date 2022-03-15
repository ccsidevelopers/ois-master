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
<p class="greet">Good day!</p>
<p class="greet">An employment application has been submitted via OIMS(direct application). The following are the details:</p><br>
<table>
    <tr>
        <td colspan="1" style=" font-weight: bold">Name</td>
        <td colspan="2">{{$name}}</td>
    </tr>
    <tr>
        <td colspan="1" style=" font-weight: bold">Age</td>
        <td colspan="2">{{$age}}</td>
    </tr>
    <tr>
        <td colspan="1" style="font-weight: bold">Gender</td>
        <td colspan="2">{{$gender}}</td>
    </tr>
    <tr>
        <td colspan="1" style="font-weight: bold">Marital Status</td>
        <td colspan="2">{{$marital}}</td>
    </tr>
    <tr>
        <td colspan="1" style="font-weight: bold">Address</td>
        <td colspan="2">{{$address}}</td>
    </tr>
    <tr>
        <td colspan="1" style="font-weight: bold">Municipality/Province</td>
        <td colspan="2">{{$muni}}</td>
    </tr>
    <tr>
        <td colspan="1" style="font-weight: bold">Tracking/Application no.</td>
        <td colspan="2">{{$tracking}}</td>
    </tr>


</table>
<p class="greet">You can now see and monitor this application on your OIMS Panel. Thank you!</p>

<br>
{{--<p style="color: black"><b><i>PS: THIS IS <u>GENERATED EMAIL</u> FROM CCSI - Online Information Managemement System PLEASE DO NOT REPLY TO THIS EMAIL. FOR ANY CLARIFICATION OR ISSUE--}}
{{--REGARDING TO THIS ACCOUNT PLEASE SEND US EMAIL HERE:</i></b></p>--}}
{{--<b>ccsijp.remobatac@gmail.com</b><br>--}}
{{--<b>ccsijf.apungan@gmail.com</b><br>--}}
{{--<b>ccsiranyll.puntanar@gmail.com</b>--}}
{{--<p> Name: {{$report_sender}}<br>--}}
{{--Position: {{$sender_position}}<br>--}}
{{--Email: {{$email_sender}}--}}
{{--</p>--}}
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