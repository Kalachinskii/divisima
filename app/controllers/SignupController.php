<?
namespace app\controllers;

use app\core\Controller;

class SignupController extends Controller
{
  public function indexAction()
  {
    if (isset($_POST["login"]) and $_POST["password"]) {
      $is_valid_login = $this->validateForm($_POST["login"], "/^[a-zA-Z][a-zA-Z0-9-_\.]{4,20}$/");
      $is_valid_password = $this->validateForm($_POST["password"], "/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/");
    
      if($is_valid_login and $is_valid_password) {
        $is_user = $this->model->check_is_user($_POST["login"]);

        if ($is_user->error) {
          $this->print_error("Не удалось зарегистрироваться", $res->error_msg);
          // пользователь не найден
        } elseif (empty($is_user)) {
          $res = $this->model->add_user($_POST["login"], $_POST["password"]);
          // 2 массива нам надо сначала проверить тот у которого м.б. ключ error
          if ($res->error) {
            $this->print_error("Не удалось зарегистрироваться", $res->error_msg);
          } else {
            // АВТОРИЗАЦИЯ
            $_SESSION['user'] = $_POST['login'];
            header("location: /");
          }
        } else {
          // вернуть попап  - юзер существует
          $signup_fail = "Пользователь {$_POST['login']} существует";
        }
      }
    }
    // $search = '123';
    // $searched = $this->model->search_products($search);
    // $data = compact('search');
    $data = compact('signup_fail');
    $this->view->layout = 'account';
    $this->view->render((object) $data);
  }

  private function validateForm($value, $regex) {
    return preg_match($regex, $value);
  }
}