<?php

namespace Core;
/**
 * Class Logger
 * @package Core
 */

class Logger
{
    /**
     * @param $params
     */
    public static function message( $params )
    {
        self::show( $params );
    }

    /**
     * @param $message
     */
    private static function show( $message )
    {
        Eben::jsonHeader();
         echo Eben::toJSON( array(
            'ApplicationException' => array(
                'message' => $message['message'],
                'code' => $message['code'],
                'request_time' => $_SERVER['REQUEST_TIME'],
                'request_uid' => uniqid(rand(10,200))
            )
        ));
    }
}