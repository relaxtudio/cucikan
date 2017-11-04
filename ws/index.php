<?php
defined('SAFELOAD') or define('SAFELOAD',true);
// ini_set('memory_limit', '256M');
// error_reporting(E_ALL);

require_once 'app/config.php';
require_once 'app/model.php';
require_once 'app/controller.php';

$url = explode("ws/",$_SERVER['REQUEST_URI']);
$urlparams = explode("/", $url[1]);
$function = $urlparams[0];
array_shift($urlparams);
$args = implode(", ", $urlparams);
// echo $args;


if (function_exists($function)) {
    // $function($urlparams);
    // $function($args);
    call_user_func_array($function, $urlparams);
}
