<?php
spl_autoload_register('classAutoLoader');

function classAutoLoader($className) {
    $folderPath = 'classes/';
    $extension = '.class.php';
    $path = $folderPath . $className . $extension;

    // Kontrola existence souboru s hledanou třídou
    if (file_exists($path)) {
        return false;
    }

    include_once $path;    
}