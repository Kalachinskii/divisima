<?
namespace app\controllers;

use app\core\Controller;

class CartController extends Controller
{


  public function indexAction()
  {
    if (empty($_SESSION['user'])) {
      
    } else {
      $cart = $this->model->get_cart($_SESSION['user']);
    }

    // $data->cart в определённом виде
    $data = compact('cart');
    $this->view->render((object) $data);
  }
}