<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5094e4c407c54da7203107fc3cb55ca0
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
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5094e4c407c54da7203107fc3cb55ca0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5094e4c407c54da7203107fc3cb55ca0::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
