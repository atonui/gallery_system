<?php

function myAutoloader($class)
{
//    $class = ucfirst(strtolower($class));

    $path = INCLUDES_PATH.DS.$class.'.php';
    require_once $path;

//    if (is_file($path) && !class_exists($path)) {
//        require_once $path;
//    } else {
//        die("<br>The file {$class}.php was not found.");
//    }
}

spl_autoload_register('myAutoloader');

function redirect($location)
{
    header("location:{$location}");
}