<?php

namespace core;
/**
 * Class DB
 * @package core
 */

abstract class DB
{
    /**
     * @var array
     */
    private static $_config = array();
    /**
     * @var null
     */
    private static $_instance = null;

    /**
     * @return null|\PDO
     */
    public static function getInstance()
    {
        if( is_null( self::$_instance ) )
        {
            self::$_instance = self::_init();
        }
       return self::$_instance;
    }

    /**
     * @param $param
     */
    public static function config( $param )
    {
        if( is_array( $param ) )
        {
            self::$_config = $param;
        }
    }

    /**
     * @return \PDO
     */
    private static function _init()
    {
        $pdo = null;

        try {
            $pdo = new \PDO(
                'mysql:host='.self::$_config['host'].';dbname='.self::$_config['db'].';charset=utf8',
                self::$_config['account'],
                self::$_config['password']
            );
        }
        catch( \Exception $e )
        {
            if( self::$_config['debug'] )
            {
                Logger::message(array(
                    'message' => $e->getMessage(),
                    'code' => $e->getCode()
                ));
                exit;
            }
        }
        return $pdo;
    }
}