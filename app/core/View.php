<?

namespace app\core;

class View
{
    private $route;
    private $view;

    public function __construct($route)
    {
        $this->route = $route;
        // подключить файл app/views/main/index.php
        $this->view = 'app/views/' . $route['controller'] . '/index.php';

        include $this->view;
    }
}
