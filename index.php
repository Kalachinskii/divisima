<?
require_once 'app/config/pathes.php';
include_once 'app/lib/debag.php';

use app\core\Router;

spl_autoload_register(function ($class) {
    echo $class;
    $class = str_replace('\\', '/', $class);
    require_once "{$class}.php";
});

$router = new Router();
$router->run();
