<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdd0fd9dc9c8e6b4737d7d5047696fcab
{
    public static $files = array (
        'decc78cc4436b1292c6c0d151b19445c' => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'p' => 
        array (
            'phpseclib3\\' => 11,
        ),
        'P' => 
        array (
            'ParagonIE\\ConstantTime\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'phpseclib3\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib',
        ),
        'ParagonIE\\ConstantTime\\' => 
        array (
            0 => __DIR__ . '/..' . '/paragonie/constant_time_encoding/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'SebastianBergmann\\Timer\\Duration' => __DIR__ . '/..' . '/phpunit/php-timer/src/Duration.php',
        'SebastianBergmann\\Timer\\Exception' => __DIR__ . '/..' . '/phpunit/php-timer/src/exceptions/Exception.php',
        'SebastianBergmann\\Timer\\NoActiveTimerException' => __DIR__ . '/..' . '/phpunit/php-timer/src/exceptions/NoActiveTimerException.php',
        'SebastianBergmann\\Timer\\ResourceUsageFormatter' => __DIR__ . '/..' . '/phpunit/php-timer/src/ResourceUsageFormatter.php',
        'SebastianBergmann\\Timer\\TimeSinceStartOfRequestNotAvailableException' => __DIR__ . '/..' . '/phpunit/php-timer/src/exceptions/TimeSinceStartOfRequestNotAvailableException.php',
        'SebastianBergmann\\Timer\\Timer' => __DIR__ . '/..' . '/phpunit/php-timer/src/Timer.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdd0fd9dc9c8e6b4737d7d5047696fcab::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdd0fd9dc9c8e6b4737d7d5047696fcab::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitdd0fd9dc9c8e6b4737d7d5047696fcab::$classMap;

        }, null, ClassLoader::class);
    }
}
