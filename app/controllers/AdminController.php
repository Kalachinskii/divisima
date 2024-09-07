<?

namespace app\controllers;

use app\core\Controller;


class AdminController extends Controller
{
  public function indexAction()
  {
    if (isset($_POST["login"]) and $_POST["password"]) {
      $is_valid_login = $this->validateForm($_POST["login"], "/^[a-zA-Z][a-zA-Z0-9-_\.]{4,20}$/");
      $is_valid_password = $this->validateForm($_POST["password"], "/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/");

      if ($is_valid_login and $is_valid_password) {
        $is_user = $this->model->check_is_user($_POST["login"]);

        if ($is_user->error) {
          $this->print_error("Не удалось авторизоваться", $res->error_msg);
        } elseif (empty($is_user)) {
          $signin_fail = "Пользователь с логином {$_POST['login']} не найден";
        } else {
          $is_password_valid = $this->model->check_user_password($is_user->id, $_POST['password']);
          if ($is_password_valid) {
            $_SESSION['user'] = $_POST['login'];
            // редирект пользовотеля
            // debug("asdasd");
            header("location: /admin/users");
          } else {
            $signin_fail = "Пароль неверный !";
          }
        }
      }
    }

    $data = compact('signin_fail');
    $this->view->layout = 'auth';
    $this->view->render((object) $data);
  }

  public function usersAction()
  {
    $users = $this->model->get_users();
    $count_users = $this->model->get_count_users();
    $count_products = $this->model->get_count_products();
    $data = compact('count_products', 'count_users', 'users');
    $this->view->layout = 'admin';
    $this->view->render((object) $data);
  }

  public function productsAction()
  {
    // получить всю продукцию
    $products = $this->model->get_products();
    $count_users = $this->model->get_count_users();
    $count_products = $this->model->get_count_products();

    $data = compact('count_products', 'count_users', 'products');
    $this->view->layout = 'admin';
    $this->view->render((object) $data);
  }

  public function deleteUserHandlerAction()
  {
    if ($this->isFetch()) {
      $json = file_get_contents('php://input');
      $userId = json_decode($json)->userId; // получили id пользвовотеля
      $this->model->delete_user($userId);
      echo true;
    } else {
      if (PROD) {
        include 'app/views/404/index.php';
      } else {
        echo '404 Page not found';
      }
    }
  }

  public function getUserProductsHandlerAction()
  {
    // функция вызывалась через fetch(true) или URL(false)
    if ($this->isFetch()) {
      $json = file_get_contents('php://input');
      $userId = json_decode($json)->userId; // получили id пользвовотеля
      $products = $this->model->get_user_products($userId);
      echo json_encode((object)($products));
    } else {
      if (PROD) {
        include 'app/views/404/index.php';
      } else {
        echo '404 Page not found';
      }
    }
  }

  private function validateForm($value, $regex)
  {
    return preg_match($regex, $value);
  }
}
