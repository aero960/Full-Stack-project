<?php


namespace WebpageMNG;




use Sabre\Event\EventEmitter;

class EventsManager
{
    private static ?EventEmitter $instance = null;


    public static function getInstance(): EventEmitter
    {
        return is_null(static::$instance) ? static::$instance = new EventEmitter() : static::$instance;
    }
}