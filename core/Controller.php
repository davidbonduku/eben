<?php

namespace Core;
/**
 * Class Controller
 * @package Core
 */
abstract class Controller implements ControllerInterface
{
    /**
     * @return array|mixed|void
     */
    public function input()
    {

        if( Request::method() == 'post' )
        {
            return Request::parsePOST();

        }else  if( Request::method() == 'get' )
        {
            return array_merge( Request::parseGET(), Request::input() );
        }else if( Request::method() == 'put' )
        {
            return file_get_contents("php://input", "r");

        }else{
            return Request::input();
        }

        return;
    }

    /**
     * @param $query null
     * @return mixed
     */
    public function queryString( $query = null )
    {
        return Request::queryString( $query );
    }

    /**
     * Message
     * @param $param
     */
    public function  message( $param )
    {
        Response::send(
            Eben::toJSON(
                array(
                    'message' => $param['message'],
                    'code' => $param['code']
                )
            )
        );
    }

}