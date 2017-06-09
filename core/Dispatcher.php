<?php

namespace Core;
/**
 * Class Dispatcher
 * @package Core
 */
class Dispatcher
{
    /**
     * Action to perform related to method given by Request
     * @var array
     */
    private static $_ACTIONS = array(
        
        'post' => 'createAction',
        'get' => 'readAction',
        'put' => 'updateAction',
        'patch' => 'updateAction',
        'delete' => 'deleteAction'

    );

    /**
     * Dispatch request to the given controller and perform action
     * @param Request $request
     */
    public static function dispatch( Request $request )
    {
        self::_instantiateController( $request::controller(), self::_getAction( $request ) );
    }

    /**
     * Get Action to perform
     * @param Request $request
     * @return mixed
     */
    private  static function _getAction( Request $request )
    {
        return self::$_ACTIONS[ $request::method() ];
    }

    /**
     * Instantiate Controller
     * @param $controller
     * @param $action
     */
    private static function _instantiateController( $controller, $action )
    {
         if( Eben::registerController( $controller ) && Eben::registerModel( $controller ) )
         {
             self::_callController( new $controller(), $action );
         }else{
            self::_controllerNotFound();
         }
    }

    /**
     * Trow Exception
     */
    private static function _controllerNotFound()
    {
        Logger::message( array(
            'message' => 'Ressource not found !',
            'code' => '404'
        ) );
    }

    /**
     * @param $controller
     * @param $action
     */
    private static function _callController( $controller, $action )
    {
        call_user_func_array(array( $controller, $action ), Request::input() );
    }

}