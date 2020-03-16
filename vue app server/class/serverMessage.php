<?php


namespace ServerMNG;


class serverMessage
{
    public static function send($msg)
    {
            $message = ["message"=> $msg];

            return json_encode($message);
    }

}