<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitab01b97a36d22a6aad3c213c396ad8cd
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitab01b97a36d22a6aad3c213c396ad8cd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitab01b97a36d22a6aad3c213c396ad8cd::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
