<?php
function confetti_redis_autoloader($class) {

    $basedir = __DIR__;

    $classname = $class;
    if(strpos($class, "\\") !== false) {
        $classname = str_replace("Connfetti\\Redis\\", "\\", $classname);
        $classname = str_replace("\\", "/", $classname);
    }

    $class_uri = $basedir."/".$classname.".php";
    if(file_exists($class_uri)) {
        include $class_uri;
    }
}
spl_autoload_register('connfetti_redis_autoloader');
