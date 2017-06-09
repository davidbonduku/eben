<?php

namespace Core;
/**
 * Class File
 * @package Cmd
 */
class File
{
    private static $_file;

    /**
     * @param $file
     * @return resource
     */
    public static function create( $file )
    {
        return fopen( $file, 'w' );
    }

    /**
     * @param $oldName
     * @param $newName
     * @return bool
     */
    public static function rename( $oldName, $newName )
    {
        return rename( $oldName, $newName );
    }

    /**
     * @param $file
     * @param $content
     */
    public static function putContent( $file, $content )
    {
        file_put_contents($file, $content );
    }

    /**
     * @param $tempName string
     * @param $fileName string
     * @param $dir string
     * @return bool
     */
    public static function upload( $tempName, $fileName, $dir )
    {
        return move_uploaded_file( $tempName, $dir.DS.$fileName );
    }

    /**
     * @param $file
     * @return int
     */
    public static function size( $file )
    {
        return filesize( $file );
    }

    /**
     * @param $file
     * @param $options
     * @return resource
     */
    public static function read( $file, $options )
    {
        return fopen( $file, $options );
    }

    /**
     * @param $file
     * @param $content
     * @return bool
     */
    public static function write( $file, $content )
    {
        self::$_file = self::create( $file );
        $done = fwrite( self::$_file, $content );
        fclose( self::$_file );

        return $done;
    }

    /**
     * @param $file
     * @return bool
     */
    public static function delete( $file )
    {
        return unlink( $file );
    }
}