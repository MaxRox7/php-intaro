<?php
spl_autoload_register('myAutoLoader');

function myAutoLoader($classname) {
    $path = "classes/";
    $extension = ".class.php";
    $fullPath = $path . $classname . $extension;


    include_once $fullPath;
}
?>