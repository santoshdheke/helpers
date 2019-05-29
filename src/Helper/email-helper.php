<?php

function sendEmail($viewPath, $data)
{
    Mail::send($viewPath, $data, function ($message) use ($data) {
        $message->to($data['email']);
        $message->subject($data['subject']);
    });
}


