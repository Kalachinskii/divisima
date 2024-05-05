<?

namespace app\core;

class Router
{
    private $routes = [];
    private $params = [];

    public function __construct()
    {
        $routes_arr = require_once "app/config/routes.php";
        foreach ($routes_arr as $route => $params) {
            $this->add_pattern_route($route, $params);
        }
    }

    private function add_pattern_route($route, $params)
    {
        $template_route = '#^' . trim($route, '/') . '$#';
        $this->routes[$template_route] = $params;
    }

    private function match()
    {
        $url_with_query = trim($_SERVER['REQUSEST_URI'], '/');
        $url = $this->remove_query_string($url_with_query);

        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                $this->params = $params;
                return true;
            }
            return false;
        }
    }

    private function remove_query_string($url)
    {
        $url_parts = explode('?', $url);
        return trim(
            $url_parts[0],
            '/'
        );
    }

    public function run()
    {
        if ($this->match()) {
            $controller_name = "\app\controllers\\" . $this->params['controller'] . 'Controller';
            if (class_exists($controller_name)) {
                echo 'yes';
            } else {
                echo 'no';
            }
        }
    }
}
