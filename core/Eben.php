<?php

 namespace Core;
 /**
  * Class Eben
  * @package Core
  */
 class Eben
 {

     const __APP_DIR__ = ROOT.'../app'.DS;
     const __VERSION__ = '0.1';
     /**
      * Run Eben Application
      */
     public static function run()
     {
         Dispatcher::dispatch( new Request() );
     }

     /**
      * @param $controller
      * @return bool
      */
     public static function registerController( $controller )
     {
         $file = self::__APP_DIR__.'controllers'.DS.strtolower( $controller ).'.php';
         return self::_loadFile( $file );
     }

     /**
      * @param $model
      * @return bool
      */
     public static function registerModel( $model )
     {
         $loaded = false;

         if( is_array( $model ) )
         {
             foreach( $model as $mod )
             {
                 $file = self::__APP_DIR__.'models'.DS.strtolower( substr( $mod, 0, -1 ) ).'.php';
                 $loaded = self::_loadFile( $file );
             }
         }else{
             $file = self::__APP_DIR__.'models'.DS.strtolower( substr( $model, 0, -1 ) ).'.php';
             $loaded = self::_loadFile( $file );
         }
         return $loaded;
     }

     /**
      * Load File
      * @param $path
      * @return bool
      */
     private static function _loadFile( $path )
     {
         if( self::isFileExist( $path ) )
         {
             require_once $path;

             return true;
         }else{
             return false;
         }
     }

     /**
      * @param $file
      * @return bool
      */
     public static function isFileExist( $file )
     {
        return ( file_exists( $file ) );
     }

     /**
      * Convert data to JSON
      * @param $data
      * @return string
      */
     public static function toJSON( $data )
     {
         return json_encode( $data );
     }

     /**
      * Convert data from JSON
      * @param $data
      * @return mixed
      */
     public static function fromJSON( $data )
     {
         return json_decode( $data );
     }

     /**
      * Set browser header to JSON format
      */
     public static function jsonHeader()
     {
         header('Content-type:application/json');
     }
 }