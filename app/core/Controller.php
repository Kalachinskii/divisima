<?

namespace app\core;

abstract class Controller
{
  protected $route;
  protected $view;
  protected $model;

  public function __construct($route)
  {
    session_start();
    // session_destroy();
    $this->route = $route;
    $this->include_model($route);
    $this->view = new View($route);
    $this->logout();
  }

  private function include_model($route)
  {
    $model_name = '\app\models\\' . $route['controller'];
    if (class_exists($model_name)) {
      $this->model = new $model_name;
    } else {
      print_error("Не удалось подключиться к БД", "Модель {$model_name} не существует");
    }
  }

  public function print_error($alert_msg, $echo_msg)
  {
    if (PROD) {
      echo "
      <script> 
        alert($alert_msg);
      </script>";
    } else {
      echo $echo_msg;
    }
  }

  public function isFetch()
  {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
  }

  public function logout()
  {
    if (isset($_GET['logout']) and $_GET['logout'] == true and !empty($_SESSION['user'])) {
      unset($_SESSION['user']);
      $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
      $url = explode('?', $url);
      header('location: ' . $url[0]);
    } else if (isset($_GET['logout']) and $_GET['logout'] == true and !empty($_SESSION['admin'])) {
      unset($_SESSION['admin']);
      header('location: /');
    }
  }
}
