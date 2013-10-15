<?php
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));
// Set Error Handler
set_error_handler('errorExceptionHandler');
function errorExceptionHandler($errNo, $errMsg, $errFile, $errLine)
{
    if (in_array($errNo, array(E_USER_ERROR, E_ERROR))) {
        throw new ErrorException($errMsg, 0, $errNo, $errFile, $errLine);
    }
    return false; // �^�_���w�]����~�B�z����
}


/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()->run();