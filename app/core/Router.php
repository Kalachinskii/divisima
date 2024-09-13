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
    $url_with_query = trim($_SERVER['REQUEST_URI'], '/'); // about/?id=1&name=bob
    // костыль или исправить обработчики дописав ключ для распознования с обычной страницей
    if ($url_with_query == 'admin/getUserProducts') {
      $url_with_query = 'getUserProducts';
    } else if ($url_with_query == 'admin/deleteUser') {
      $url_with_query = 'deleteUser';
    } else if ($url_with_query == 'admin/getTargetProduct') {
      $url_with_query = 'getTargetProduct';
    } else if ($url_with_query == 'admin/changeProduct') {
      $url_with_query = 'changeProduct';
    } else if ($url_with_query == 'admin/addImageDd') {
      $url_with_query = 'addImageDd';
    } else if ($url_with_query == 'admin/deleteProduct') {
      $url_with_query = 'deleteProduct';
    } else if ($url_with_query == 'admin/addNewProduct') {
      $url_with_query = 'addNewProduct';
    } else if ($url_with_query == 'admin/addNewCategory') {
      $url_with_query = 'addNewCategory';
    } else if ($url_with_query == 'admin/getAllCategory') {
      $url_with_query = 'getAllCategory';
    } else if ($url_with_query == 'admin/deleteCategory') {
      $url_with_query = 'deleteCategory';
    }

    $url = $this->removeQueryString($url_with_query);

    foreach ($this->routes as $route => $params) {
      if (preg_match($route, $url, $matches)) {
        $this->params = $params;
        return true;
      }
    }
    return false;
  }

  private function removeQueryString($url)
  {
    $parts = explode('?', $url);
    return trim($parts[0], '/'); // about
  }

  // запускаеться от главного index.php
  public function run()
  {
    if ($this->match()) {
      $controller_name = "\app\controllers\\" . $this->params['controller'] . 'Controller';

      if (class_exists($controller_name)) {
        $controller = new $controller_name($this->params);
        $action_name = $this->params['action'] . 'Action'; // 'indexAction'
        if (method_exists($controller, $action_name)) {
          $controller->$action_name();
        } else {
          if (PROD) {
            include 'app/views/404/index.php';
          } else {
            echo 'Метод ' . $action_name . ' не найден';
          }
        }
      } else {
        if (PROD) {
          include 'app/views/404/index.php';
        } else {
          echo 'Класс ' . $controller_name . ' не найден';
        }
      }
    } else {
      if (PROD) {
        include 'app/views/404/index.php';
      } else {
        echo '404 Page not found';
      }
    }
  }
}
