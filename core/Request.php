<?php

namespace Core;
/**
 * Class Request
 * @package Core
 */
class Request
{
    /**
     * @return string
     */
    public static function method()
    {
        return strtolower( $_SERVER['REQUEST_METHOD'] );
    }

    /**
     * @return array
     */
    public static function input()
    {
        return self::parseInput();
    }

    /**
     * QueryString
     * @param string $query
     * @return mixed|string
     */
    public static function queryString( $query = null )
    {
        $queryString =  $_SERVER['QUERY_STRING'];

        if( !is_null( $query ) )
        {
            return self::_findQueryString( $query, $queryString );
        }else{
            return self::_findAllQueryString( $queryString );
        }
    }

    /**
     * FindQueryString
     * @param $query
     * @param $data
     * @return mixed|string
     */
    private static function _findQueryString( $query, $data )
    {
        $data = @explode('&', $data );
        $result = '';

        foreach( $data as $d )
        {
            if( strpos( $d, $query ) !== false )
            {
                $value = @str_replace( $query.'=','',$d );
                $result = $value;
            }
        }

        return $result;
    }

    /**
     * Find All Query String
     * @param $data
     * @return array
     */
    private static function _findAllQueryString( $data )
    {
        if( empty( $data ) ) return array();

        $data = @explode('&', $data );
        $result = array();

        foreach( $data as $d )
        {
            $current = @explode( '=',$d );
            $result[ @$current[0] ] =  @$current[1];
        }

        return $result;
    }

    public static function Cookies()
    {

    }

    /**
     * ControllerName
     * @return mixed
     */
    public static function controller()
    {
        $controller =  self::parseRequestAndFindRessource();

        return $controller = @$controller[0];
    }

    /**
     * @return mixed
     */
    private static function parseRequestAndFindRessource()
    {
        $request = @explode(ROOT, $_SERVER['REQUEST_URI'] );
        $ressource = @explode('/', @$request[0] );

        $data = explode( DS, APP_ROOT );

        $current_ressource = $data[ sizeof($data)-1 ];

        $ressource = ( $current_ressource === @$ressource[2] ) ? @$ressource[3] : @$ressource[2];

        $rq = @explode( '?', $ressource);

        return $rq;
    }

    /**
     *
     * @return array
     */
    private static function parseInput()
    {
        $request = @explode( self::controller(), $_SERVER['REQUEST_URI'] );
        $ressource = @explode( '/', @$request[1] );
        unset( $ressource[0] );

        return $ressource;
    }

    /**
     * @return mixed
     */
    public static function parseGET()
    {
        return $_GET;
    }

    /**
     * @return mixed
     */
    public static function parsePOST()
    {
        return $_POST;
    }

}