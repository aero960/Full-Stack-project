<?php


namespace ServerMNG;


class serverMessage
{
    public static function send($name , $msg)
    {
            $message = [$name=> $msg];

            return json_encode($message);
    }

}