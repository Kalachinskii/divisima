<?
namespace app\controllers;

use app\core\Controller;

class AdminController extends Controller {
  
  public function indexAction()
  {
    if (isset($_POST["login"]) and $_POST["password"]) {
      $is_valid_login = $this->validateForm($_POST["login"], "/^[a-zA-Z][a-zA-Z0-9-_\.]{4,20}$/");
      $is_valid_password = $this->validateForm($_POST["password"], "/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/");
    
      if($is_valid_login and $is_valid_password) {
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
            header("location: /admin/users");
          } else {
            $signin_fail = "Пароль неверный !";
          }
        }
      }
    }

    $data = compact('signin_fail');
    $this->view->layout = 'account';
    $this->view->render((object) $data);
  }

  private function validateForm($value, $regex)
  {
    return preg_match($regex, $value);
  }
}