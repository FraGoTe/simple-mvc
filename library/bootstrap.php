<?php 
// Ensure we have session
if(session_id() === ""){
    session_start();
}

$path = ROOT . DS . 'config' . DS . 'config.php';

// include the config settings
require_once ($path);

// Autoload any classes that are required
spl_autoload_register(function($className) {

    //$className = strtolower($className);
    $rootPath = ROOT . DS;
    $valid = false;
   
    // check root directory of library
    $valid = file_exists($classFile = $rootPath . 'library' . DS . $className . '.class.php');
    
    // if we cannot find any, then find library/core directory
    if(!$valid){
        $valid = file_exists($classFile = $rootPath . 'library' . DS . 'core' . DS . $className . '.class.php');   	
    }
    // if we cannot find any, then find library/mvc directory
    if(!$valid){
        $valid = file_exists($classFile = $rootPath . 'library' . DS . 'mvc' . DS . $className . '.class.php');
    }     
    // if we cannot find any, then find application/controllers directory
    if(!$valid){
        $valid = file_exists($classFile = $rootPath . 'application' . DS . 'controllers' . DS . $className . '.php');
    } 
    // if we cannot find any, then find application/models directory
    if(!$valid){
        $valid = file_exists($classFile = $rootPath . 'application' . DS . 'models' . DS . $className . '.php');
    }  
  
    // if we have valid fild, then include it
    if($valid){
       require_once($classFile); 
    }else{
        /* Error Generation Code Here */
    }    
});


// remove the magic quotes
MyHelpers::removeMagicQuotes();

// unregister globals
MyHelpers::unregisterGlobals();

// register route
$router = new Router($_route);

// finaly we dispatch the output
$router->dispatch();

// close session to speed up the concurrent connections
// http://php.net/manual/en/function.session-write-close.php
session_write_close();