<?php

namespace Cmd;
/**
 * Class EbenCLI
 * @package Cmd
 */
class EbenCLI
{
    /**
     * @var string
     */
    private static $_controllers_location = 'controllers';
    /**
     * @var string
     */
    private static $_models_location = 'models';
    /**
     * @var string
     */
    private static $_app_directory = 'app';

    private static $_template_location = 'template';
    /**
     * Init
     */
    public static function init()
    {
        self::_welcomeMessage();
        self::_message("\n\n");
    }

    /**
     * Create New Project
     */
    private static function _newProject()
    {
        self::_createNewAppDirectory();
        self::_createConfigAssetDirectoryAndAssets( new File() );
        self::_createHtaccessFile( new File() );
        self::_createFrontController();

        if( !is_dir( ROOT.'../../'.self::$_app_directory.DS.self::$_controllers_location )
            || !is_dir( ROOT.'../../'.self::$_app_directory.DS.self::$_models_location ) )
        {
            mkdir( ROOT.'../../'.self::$_app_directory.DS.self::$_controllers_location );
            mkdir( ROOT.'../../'.self::$_app_directory.DS.self::$_models_location );

        }else{
            self::_message( "This projet already exist \n\n" );
        }
    }

    /**
     */
    private static function _createNewAppDirectory()
    {

        if( !is_dir( ROOT.'../../'.self::$_app_directory ) )
        {
            mkdir(  ROOT.'../../'.self::$_app_directory );
            self::_message( "New Projet was successfully created. Application is in app folder ! \n\n" );

        }else{
            self::_message( "This projet already exist \n\n" );
        }
    }

    /**
     * @param File $file
     */
    private static function _createConfigAssetDirectoryAndAssets( File $file )
    {
        mkdir( ROOT.'../../'.self::$_app_directory.DS.'config');

        $file::write(
            ROOT.'../../'.self::$_app_directory.DS.'config'.DS.'conf.php',
            file_get_contents( self::$_template_location.DS.'conf.eben' )
        );
    }

    /**
     * @param File $file
     */
    private static function _createHtaccessFile( File $file )
    {
        $file::write(
            ROOT.'../../'.'.htaccess',
            file_get_contents( self::$_template_location.DS.'htaccess.eben' )
        );
    }

    /**
     * Create front controller
     */
    private static function _createFrontController()
    {
        File::write(
            ROOT.'../../index.php',
            file_get_contents( self::$_template_location.DS.'front.controller.eben')
        );
    }

    /**
     * CreateController
     * @param $name
     * @param File $fileMaker
     */
    private static function _createController( $name , File $fileMaker )
    {
        $controllerContent = self::_controllerTemplate( $name );
        $location = ROOT.'../../'.self::$_app_directory.DS.self::$_controllers_location.DS.$name.'.php';

        if( file_exists( $location ) )
        {
            self::_message( " Error, $name controller already exist! \n\n" );
        }else{
            $fileMaker::write( $location, $controllerContent );
            self::_successMessage( $name );
        }
    }

    /**
     * @param $name
     * @param File $fileMaker
     */
    private static function _createModel($name, File $fileMaker)
    {
        $modelContent = self::_modelTemplate( $name );
        $location = ROOT.'../../'.self::$_app_directory.DS.self::$_models_location.DS.$name.'.php';

        if( file_exists( $location ) )
        {
            self::_message( " Error, $name model already exist! \n\n" );
        }else{
            $fileMaker::write( $location, $modelContent );
            self::_successMessage( $name );
        }
    }

    /**
     * Action to perform
     * @param array $params
     */

    public static function action( $params  = array() )
    {
        unset ($params[0]);


        if( $params[1] === 'build' )
        {
            unset ( $params[1] );
            self::_actionToPerform( $params[2], $params );
        }
        else if( $params[1] === 'new' )
        {

            self::_newProject( );
        }
        else{
            self::_message( " No action performed, good bye.\n \n" );
        }
    }

    /**
     * Action to perform
     * @param $action
     * @param $data
     */

    private function _actionToPerform( $action, $data )
    {
        if( $action === '--component' )
        {
            unset( $data[2]);

            self::_creationControllerMessage();

            if( self::prompt() == 'yes' )
            {
                foreach( $data as $controller )
                {
                    self::_createController( $controller, new File() );
                    self::_createModel( substr( $controller, 0, -1 ), new File() );
                }

            }else{
                self::_message( " No action performed, good bye.\n \n" );
                exit;
            }
        }else if( $action === '--model' )
        {
            self::_message( "Not developed yet, i'm sorry...\n\n" );
            exit;
        }
    }

    /**
     * Prompt
     * @return string
     */
    public static function prompt()
    {
        $handle = fopen ("php://stdin","r");
        $line = fgets($handle);
        return trim( $line );
    }

    /**
     * Controller Template
     * @param $controllerName
     * @return string
     */
    private static function _controllerTemplate( $controllerName )
    {
        $template =  file_get_contents(  self::$_template_location.DS.'controller.eben' );
        return str_replace('$controller', $controllerName, $template);
    }

    private static function _modelTemplate( $model)
    {
        $template =  file_get_contents(  self::$_template_location.DS.'model.eben' );
        return str_replace('$model', $model, $template);
    }

    /**
     * Welcome Message
     */

    private static function _welcomeMessage()
    {
        self::_message( file_get_contents( self::$_template_location.DS.'cli.eben') );
    }

    /**
     * Creation ControllerMessage Message
     */
    private static function _creationControllerMessage()
    {
        self::_message( "Do you want to create Controller and Model ? Type 'yes' to continue: \n" );
    }

    /**
     * SuccessMessage
     * @param $message
     */

    private static function _successMessage( $message )
    {
        self::_message( " $message was successfully created... \n" );
    }

    /**
     * @param $content
     */
    private static function _message( $content )
    {
        echo $content;
    }
}