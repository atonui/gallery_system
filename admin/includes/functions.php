<?php

function myAutoloader($class)
{
    $class = ucfirst(strtolower($class));

    $path = 'includes/{$class}.php';

    if (is_file($path) && !class_exists($class)) {
        include $path;
    } else {
        die("<br>The file {$class}.php was not found.");
    }
}

spl_autoload_register('myAutoloader');

function redirect($location)
{
    header("location:{$location}");
}