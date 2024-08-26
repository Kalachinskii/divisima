<?
namespace app\controllers;

use app\core\Controller;

class CartController extends Controller
{

  public function indexAction()
  {
    if (empty($_SESSION['user'])) {
      if (isset($_COOKIE['cart'])) {
        // получение колличества элементов у неавторизованного пользовотеля в корзине
        $cart = unserialize($_COOKIE['cart']);
        $cart_qty = array_sum($cart);
        $cart = $this->model->get_cart_no_name($cart);
        // debug($cart);
      }
    } else {
      // получение колличества элементов у пользовотеля в корзине
      $cart = $this->model->get_cart($_SESSION['user']);
      $cart_qty = $this->model->get_cart_qty($_SESSION["user"]);
    }

    // $data->cart в определённом виде
    $data = compact('cart', 'cart_qty');
    $this->view->render((object) $data);
  }
}