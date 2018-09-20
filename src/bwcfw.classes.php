<?php
namespace wugms;

/**
 * This is the primary autoloader for the classes
 */
spl_autoload_register(function ($class) {
    $fileNameRaw = str_replace('wugms', 'src', $class);
    $fileName = str_replace('\\', '/', $fileNameRaw);
    $fullFileName = dirname(__DIR__) . '/' . $fileName . '.php';
    if (file_exists($fullFileName)) {
        require $fullFileName;
    }
});
