<?php

/**
 * Eben Command line application
 * @usage  php Builder.php new
 *         php Builder.php build --component ControllerName
 */

use Cmd\Autoloader;
use Cmd\EbenCLI;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__).DS);

require_once 'Autoloader.php';

Autoloader::register();

EbenCLI::init();
EbenCLI::action( $argv );