<?php
/*// Répertoire du fichier autoload.php
spl_autoload_register(function ($className) {
    @include __DIR__ . "/" . strtr($className, "\\", "/") . ".php";
});
// Répertoire Classes du répertoire du fichier autoload.php
spl_autoload_register(function ($className) {
    @include __DIR__ . "/Classes/".strtr($className, "\\", "/").".php";
});
// Répertoire courant
spl_autoload_register(function ($className) {
    @include strtr($className, "\\", "/") . ".php";
});
// Répertoire Classes du répertoire courant
spl_autoload_register(function ($className) {
    @include "Classes/".strtr($className, "\\", "/").".php";
});*/

spl_autoload_register(function($className) {
    $file = __DIR__ . '\\Classes\\' . $className . '.php';
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
    if (file_exists($file)) {
        include $file;
    }
});