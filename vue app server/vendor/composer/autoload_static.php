<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit01c91c4387f738018d13d65db24ae3fd
{
    public static $files = array (
        'b0a53c04370b7a582e95268dd0e194c0' => __DIR__ . '/../..' . '/helper/Helper.php',
        '07f131b690bec6d9408001ef05c03ba4' => __DIR__ . '/../..' . '/test/test.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Phroute\\Phroute\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Phroute\\Phroute\\' => 
        array (
            0 => __DIR__ . '/..' . '/phroute/phroute/src/Phroute',
        ),
    );

    public static $classMap = array (
        'RoutesMNG\\ManipulateRoute' => __DIR__ . '/../..' . '/class/middleware.php',
        'RoutesMNG\\Route' => __DIR__ . '/../..' . '/class/middleware.php',
        'RoutesMNG\\RouteAdministrator' => __DIR__ . '/../..' . '/class/middleware.php',
        'RoutesMNG\\RouteManager' => __DIR__ . '/../..' . '/class/middleware.php',
        'RoutesMNG\\SingleRoute' => __DIR__ . '/../..' . '/class/middleware.php',
        'ServerMNG\\serverMessage' => __DIR__ . '/../..' . '/class/serverMessage.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit01c91c4387f738018d13d65db24ae3fd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit01c91c4387f738018d13d65db24ae3fd::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit01c91c4387f738018d13d65db24ae3fd::$classMap;

        }, null, ClassLoader::class);
    }
}
