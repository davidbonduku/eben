<?php

namespace Core;
/**
 * Class Autoloader
 * @package Core
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

        $path = implode(DS, $parts);

        $file = $className.'.php';

        $filepath = ROOT.strtolower($path).DS.$file;

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