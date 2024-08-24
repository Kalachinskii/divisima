<?
namespace app\core;

class View
{

  private $route;
  private $view;

  public $layout = 'default';
  public function __construct($route)
  {
    $this->route = $route;
    $this->view = 'app/views/' . $route['controller'] . '/index.php';
    // include $this->view;
  }

  public function render($data = null)
  {
    $layout = 'app/views/layouts/' . $this->layout . '.php';

    if (file_exists($this->view)) {
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