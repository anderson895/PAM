<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit474b14eebe3ff545df6218a9a7e78c62
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit474b14eebe3ff545df6218a9a7e78c62::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit474b14eebe3ff545df6218a9a7e78c62::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit474b14eebe3ff545df6218a9a7e78c62::$classMap;

        }, null, ClassLoader::class);
    }
}
