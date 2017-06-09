<?php

namespace Core;
/**
 * Class Response
 * @package Core
 */
class Response
{
    /**
     * Send Response to client
     * @param $data
     */
    public static function send( $data = null )
    {
        self::_sendResponseToBrowser( $data );
    }

    /**
     * Send Data to the client
     * @param $data
     */
    private static function _sendResponseToBrowser( $data )
    {
        Eben::jsonHeader();
        if( is_null( $data ) ) return;
        echo $data;
    }

}