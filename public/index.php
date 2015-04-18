<?php
// Ensure we have session
if(session_id() === ""){
    session_start();
}

// define the directory separator
define('DS', DIRECTORY_SEPARATOR);
// define the application path
define('ROOT', dirname(dirname(__FILE__)));

// the routing url, we need to use original 'QUERY_STRING' from server paramater because php has parsed the url if we use $_GET
$_route = isset($_GET['_route']) ? preg_replace('/^_route=(.*)/','$1',$_SERVER['QUERY_STRING']) : '';

// start to dispatch
require_once (ROOT . DS . 'library' . DS . 'bootstrap.php');