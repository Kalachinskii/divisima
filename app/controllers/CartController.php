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

  public function addDelToCartHandlerAction() 
  {
    if ($this->isFetch()) {
      $json = file_get_contents('php://input');
      $data = json_decode($json);
      $product_id = $data->productId;
      $method = $data->method;
      // добавление товара
      // не авторизован - кука
      if(empty($_SESSION["user"])) {
        if(isset($_COOKIE['cart'])) {
          $cart = unserialize($_COOKIE['cart']);
          if (array_key_exists($product_id, $cart)) {
            if ($method == "del") {
              foreach ($cart as $key => &$value) {
                if ($key == $product_id) {
                  $value--;
                }
              }
            } else if ($method == "add") {
              foreach ($cart as $key => &$value) {
                if ($key == $product_id) {
                  $value++;
                }
              }
            }
            setcookie("cart", serialize($cart), time() + 3600); 
          } else {
            $cart[$product_id] = 1;
            setcookie("cart", serialize($cart), time() + 3600); 
          }  
        } else {
          $cart[$product_id] = 1;
          setcookie("cart", serialize($cart), time() + 3600);
        }
      // добавление товара
      // авторизован - БД
      } else {
        $method_function = $method . "_to_cart";
        // $res = $this->model->add_or_del_to_cart($_SESSION['user'], $product_id, $method);
        $res = $this->model->$method_function($_SESSION['user'], $product_id);
        if ($res->error) {
          $this->print_error("Не удалось добавить товар в корзину попробуйте позже", $res->error_msg);
          echo json_encode(false);
        } else {
          echo json_encode(true);
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

  public function currentSqyProductsHandlerAction() 
  {
    if ($this->isFetch()) {
      $json = file_get_contents('php://input');
      $data = json_decode($json);
      $product_id = $data->productId;
      $currentSqy = $data->currentSqy;
      // добавление товара
      // не авторизован - кука
      if(empty($_SESSION["user"])) {
        if(isset($_COOKIE['cart'])) {
          $cart = unserialize($_COOKIE['cart']);
          debug($cart);
          if (array_key_exists($product_id, $cart)) {
            foreach ($cart as $key => &$value) {
              if ($key == $product_id) {
                $value = $currentSqy;
              }
            }
            setcookie("cart", serialize($cart), time() + 3600); 
          }
        } 
      // добавление товара
      // авторизован - БД
      } else {
        // $method_function = $method . "";
        // $res = $this->model->add_or_del_to_cart($_SESSION['user'], $product_id, $method);
        $res = $this->model->current_to_cart($_SESSION['user'], $product_id, $currentSqy);
        if ($res->error) {
          $this->print_error("Не удалось добавить товар в корзину попробуйте позже", $res->error_msg);
          echo json_encode(false);
        } else {
          echo json_encode(true);
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