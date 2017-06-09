<?php
/**
 * Eben Micro Framework
 * @author David BONDUKU
 * @version 0.1.alpha
 */
namespace Eben;
use Core\Autoloader;
use Core\Eben;

header("Access-Control-Allow-Origin: *");
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__).DS);

session_start();

require_once 'core/Autoloader.php';

Autoloader::register();
require_once Eben::__APP_DIR__.'config/conf.php';

Eben::run();
