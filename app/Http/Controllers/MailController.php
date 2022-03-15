<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function html_email()
    {
        $data = array
        (
            'name'=>"John Michael",
            'age'=>3
        );
        Mail::send('mail', $data, function($message)
        {
            $message->to('johnmichael.rodanillo@gmail.com', 'Tutorials Point')->subject
            ('Laravel HTML Testing Mail');
            $message->from('xyz@gmail.com','Virat Gandhi');
        });
        echo "HTML Email Sent. Check your inbox.";
    }

    public function attachment_email()
    {
        $data = array
        (
            'name'=>"ATTACHMENT",
            'age'=>3
        );

        Mail::send('mail', $data, function($message) {
            $message->to('johnmichael.rodanillo@gmail.com', 'Tutorials Point')->subject
            ('Laravel Testing Mail with Attachment');
            $message->attach(storage_path('app/public/avatar.png'));
            $message->from('xyz@gmail.com','Virat Gandhi');
        });
        echo "Email Sent with attachment. Check your inbox.";
    }
}
