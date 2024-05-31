<?php

spl_autoload_register(function($className) {
    $file = __DIR__ . "/Class/$className.php";
    if (file_exists($file)) {
        include_once $file;
    }
});
