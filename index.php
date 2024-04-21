<?
// include "app/cor/Router.php";
// new Router();

// ПРОСТРАНСТВО ИМЁН - 
use app\core\Router;

// мама инклудит при создании экземпляра класса
spl_autoload_register(function ($class) {
    echo $class;
    $class = str_replace('\\', '/', $class);
    require_once "{$class}.php";
});

new Router();
