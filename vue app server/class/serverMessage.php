<?php


namespace ServerMNG;


class serverMessage
{
    public static function send($name, $msg)
    {
        $message = [$name => $msg];

       return json_encode($message,  JSON_PRETTY_PRINT, 512);
    }

    public static function errorMessage(): string
    {
       return '⛔ You probably cannot use this ⛔';
    }

}