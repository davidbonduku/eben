<?php

namespace Cmd;
/**
 * Class Autoloader
 * @package Cmd
 */
class Autoloader{
    /**
     *  Register Autoloader
     */
    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }
    /**
     * Autoload
     * @param $class
     */

    public static function autoload( $class )
    {

        $parts = preg_split('#\\\#', $class);

        $className = array_pop($parts);

        $file = $className.'.php';

        $filepath = ROOT.DS.$file;

        if( self::_isFileExist( $filepath ) )
        {
            require $filepath;
        }

        return;
    }

    /**
     * @param $path
     * @return bool
     */
    private static function _isFileExist( $path )
    {
        return file_exists( $path );
    }
}