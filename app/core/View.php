<?

namespace app\core;

class View
{

  private $route;
  private $view;

  public $layout = 'default';
  public function __construct()
  {
    // $this->route = $route;
    // путь к файлу
    // $this->view = 'app/views/' . $route['controller'] . '/index.php';
    // debug();
    $a = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
    $this->view = empty($a[0]) ? 'app/views/main/index.php' : 'app/views/' . $a[count($a) - 1] . '/index.php';
  }

  public function render($data = null)
  {
    $layout = 'app/views/layouts/' . $this->layout . '.php';

    if (file_exists($this->view)) {
      // сохранить в буфер
      ob_start();
      include $this->view;
      $content = ob_get_clean();
    } else {
      if (PROD) {
        include 'app/views/503/index.php';
      } else {
        echo 'Вид: ' . $this->view . ' не найден';
      }
    }

    if (file_exists($layout)) {
      include $layout;
    }
  }
}
/*
  // путь к контент файлу
  $this->view = 'app/views/' . $route['controller'] . '/index.php';

  АВТОРИЗАЦИЯ - app/views/authorization/index.php
  PATH . "/admin" => [
    'controller' => 'authorization',
    'action' => 'index'
  ],

  
  // РАБОТА с пользователями - app/views/admin/index.php
  PATH . "/admin/users" => [
    'controller' => 'admin',
    'action' => 'users'
  ],
  // РАБОТА с продуктами - app/views/admin/index.php
  PATH . "/admin/products" => [
    'controller' => 'admin',
    'action' => 'products'
  ],
*/