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
        $is_admin = $this->model->check_is_admin($_POST["login"]);
        if ($is_admin->error) {
          $this->print_error("Не удалось авторизоваться", $is_admin->error_msg);
        } elseif (empty($is_admin)) {
          $signin_fail = "Пользователь с логином {$_POST['login']} не найден";
        } else {
          $is_password_valid = $this->model->check_user_password($is_admin[0]->id, $_POST['password']);

          if ($is_password_valid) {
            $_SESSION['admin'] = $_POST['login'];
            // debug($_SESSION['admin']);
            header("location: /admin/users");
          } else {
            $signin_fail = "Пароль неверный !";
          }
        }
      }
    }

    if (empty($_SESSION['admin'])) {
      $data = compact('signin_fail');
      $this->view->layout = 'auth';
      $this->view->render((object) $data);
    } else {
      header("location: /admin/users");
    }
  }

  public function usersAction()
  {
    if (!empty($_SESSION['admin'])) {
      $users = $this->model->get_users();
      $count_users = $this->model->get_count_users();
      $count_products = $this->model->get_count_products();
      $data = compact('count_products', 'count_users', 'users');
      $this->view->layout = 'admin';
      $this->view->render((object) $data);
    } else {
      if (PROD) {
        include 'app/views/404/index.php';
      } else {
        echo '404 Page not found';
      }
    }
  }

  public function productsAction()
  {
    if (!empty($_SESSION['admin'])) {
      // получить всю продукцию
      $products = $this->model->get_products();
      $count_users = $this->model->get_count_users();
      $count_products = $this->model->get_count_products();
      $categories = $this->model->get_categories();

      $data = compact('count_products', 'count_users', 'products', 'categories');
      $this->view->layout = 'admin';
      $this->view->render((object) $data);
    } else {
      if (PROD) {
        include 'app/views/404/index.php';
      } else {
        echo '404 Page not found';
      }
    }
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

  public function addImageDdHandlerAction()
  {
    if ($this->isFetch()) {
      if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $name_img = $_FILES['image']['name'];           //     22.png
        $path_to_img_folder = "./public/img/product/";   //     /public/img/product
        $path_to_img = $path_to_img_folder . $name_img; //     /public/img/product/22.png

        if (is_dir($path_to_img_folder)) {
          if (move_uploaded_file($_FILES['image']['tmp_name'], $path_to_img)) {
            echo $name_img;
          } else {
            echo "Файл не загружен";
          }
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

  public function changeProductHandlerAction()
  {
    if ($this->isFetch()) {
      $json = file_get_contents('php://input');
      $data = json_decode($json)->formContent;
      debug($data);
      $this->model->set_product($data);
    } else {
      if (PROD) {
        include 'app/views/404/index.php';
      } else {
        echo '404 Page not found';
      }
    }
  }

  public function addNewCategoryHandlerAction()
  {
    if ($this->isFetch()) {
      $json = file_get_contents('php://input');
      $data = json_decode($json)->category;
      $this->model->add_new_category($data);
    } else {
      if (PROD) {
        include 'app/views/404/index.php';
      } else {
        echo '404 Page not found';
      }
    }
  }


  public function addNewProductHandlerAction()
  {
    if ($this->isFetch()) {
      $json = file_get_contents('php://input');
      $data = json_decode($json)->formContent;
      debug($data);
      $this->model->add_new_product($data);
    } else {
      if (PROD) {
        include 'app/views/404/index.php';
      } else {
        echo '404 Page not found';
      }
    }
  }

  public function deleteProductHandlerAction()
  {
    if ($this->isFetch()) {
      $json = file_get_contents('php://input');
      $data = json_decode($json);
      debug($data);
      $this->model->deleteProduct($data);
    } else {
      if (PROD) {
        include 'app/views/404/index.php';
      } else {
        echo '404 Page not found';
      }
    }
  }

  public function getProductsBySearchHandlerAction()
  {
    if ($this->isFetch()) {
      $json = file_get_contents('php://input');
      $data = json_decode($json);
      $products = $this->model->get_products_by_search($data);
      // debug($products);
      echo json_encode((array)($products));
    } else {
      if (PROD) {
        include 'app/views/404/index.php';
      } else {
        echo '404 Page not found';
      }
    }
  }

  public function getUsersBySearchHandlerAction()
  {
    if ($this->isFetch()) {
      $json = file_get_contents('php://input');
      $data = json_decode($json);
      $users = $this->model->get_users_by_search($data);
      // debug($products);
      echo json_encode((array)($users));
    } else {
      if (PROD) {
        include 'app/views/404/index.php';
      } else {
        echo '404 Page not found';
      }
    }
  }

  public function getTargetProductHandlerAction()
  {
    // функция вызывалась через fetch(true) или URL(false)
    if ($this->isFetch()) {
      $json = file_get_contents('php://input');
      $productId = json_decode($json)->productId; // получили id товара
      $product = $this->model->get_product($productId);
      $categorieId = $this->model->get_categorie_id($productId);
      $categories = $this->model->get_categories_not_id($categorieId[0]->category_id);
      echo json_encode((object)([$product, $categories, $categorieId[0]->category_id]));
    } else {
      if (PROD) {
        include 'app/views/404/index.php';
      } else {
        echo '404 Page not found';
      }
    }
  }

  public function deleteCategoryHandlerAction()
  {
    if ($this->isFetch()) {
      $id = file_get_contents('php://input');
      $this->model->delete_category_id($id);
    } else {
      if (PROD) {
        include 'app/views/404/index.php';
      } else {
        echo '404 Page not found';
      }
    }
  }

  public function getAllCategoryHandlerAction()
  {
    $categories = $this->model->get_categories();
    echo json_encode((object)($categories));
  }

  private function validateForm($value, $regex)
  {
    return preg_match($regex, $value);
  }
}
