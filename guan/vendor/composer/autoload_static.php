<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5af1fdc2be351821bd3647a5a02afd57
{
    public static $prefixLengthsPsr4 = array (
        'h' => 
        array (
            'houdunwang\\dir\\' => 15,
        ),
        'P' => 
        array (
            'Payment\\' => 8,
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'O' => 
        array (
            'Overtrue\\Pinyin\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'houdunwang\\dir\\' => 
        array (
            0 => __DIR__ . '/..' . '/houdunwang/dir/src',
        ),
        'Payment\\' => 
        array (
            0 => __DIR__ . '/..' . '/riverslei/payment/src',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Overtrue\\Pinyin\\' => 
        array (
            0 => __DIR__ . '/..' . '/overtrue/pinyin/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5af1fdc2be351821bd3647a5a02afd57::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5af1fdc2be351821bd3647a5a02afd57::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
