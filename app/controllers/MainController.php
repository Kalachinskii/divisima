<?
namespace app\controllers;

use app\core\Controller;

class MainController extends Controller
{
  private $start = 0;
  private $limit = 4;

  public function indexAction()
  {
    include LIB . '/texts/main.php';
    $banners_urls = $this->model->get_banners();
    $features_urls = $this->model->get_features();
    $categories = $this->model->get_categories();
    $products = $this->model->get_products($this->start, $this->limit);
    $hot = 4;
    $hot_products = $this->model->get_hot_products($hot);
    if(!empty($_SESSION["user"])) {
      $favourites_array = $this->model->get_favorite_products($_SESSION["user"]);

      if (!empty($favourites_array)) {
        $favourites = array_map(function($item) {
          return $item->product_id;
        }, $favourites_array);
      }

      // получение колличества элементов у пользовотеля в корзине
      $cart_qty = $this->model->get_cart_qty($_SESSION["user"]);
    }

    $banners = $this->add_object_texts($banners_urls, $banners_texts);
    $features = $this->add_object_texts($features_urls, $features_texts);

    $data = compact('banners', 'features', 'categories', 'products', 'hot_products', 'favourites', 'cart_qty');
    $this->view->render((object) $data);
  }

  private function add_object_texts($data, $data_texts)
  {
    foreach ($data as $ind => $item) {
      $item->texts = (object) $data_texts[$ind];
    }
    return $data;
  }

  public function categoryProductsHandlerAction()
  {
    // как вызывалась функция через fetch то ок или URL то нет
    if ($this->isFetch()) {
      //Здесь теперь принимаем объект ->start   ->category_id
      $json = file_get_contents('php://input');
      $data = json_decode($json);
      $category_id = $data->categoryId;
      $load_more_limit = 2;

      if (is_numeric($category_id) and $category_id == 0) {
        $products = $this->model->get_products($data->start ? $data->start : $this->start, $data->start ? $load_more_limit : $this->limit);
        echo json_encode($products);
      } elseif (is_numeric($category_id)) {
        $products = $this->model->get_category_products($category_id, $data->start ? $data->start : $this->start, $data->start ? $load_more_limit : $this->limit);
        echo json_encode($products);
      } else {
        echo json_encode(false);
      }
    } else {
      if (PROD) {
        include 'app/views/404/index.php';
      } else {
        echo '404 Page not found';
      }
    }
  }

  public function addToFavouritesHandlerAction()
  {
    if ($this->isFetch()) {
      $json = file_get_contents('php://input');
      $data = json_decode($json);
      $product_id = $data->productId;

      // РАЗОБРАТЬСЯ
      if(empty($_SESSION["user"])) {
        echo json_encode(401);
        return;
      }

      $res = $this->model->add_to_favourites($_SESSION["user"], $product_id);
      if ($res->error) {
        $this->print_error("Не удалось добавить товар в избранное попробуйте позже", $res->error_msg);
        echo json_encode(false);
      } else {
        echo json_encode(true);
      }
    } else {
      if (PROD) {
        include 'app/views/404/index.php';
      } else {
        echo '404 Page not found';
      }
    }
  }

  public function deleteToFavouritesHandlerAction()
  {
    if ($this->isFetch()) {
      $json = file_get_contents('php://input');
      $data = json_decode($json);
      $product_id = $data->productId;
      $res = $this->model->delete_from_favourites($_SESSION["user"], $product_id);
      if ($res->error) {
        $this->print_error("Не удалось удалить товар из избранное попробуйте позже", $res->error_msg);
        echo json_encode(false);
      } else {
        echo json_encode(true);
      }
    } else {
      if (PROD) {
        include 'app/views/404/index.php';
      } else {
        echo '404 Page not found';
      }
    }
  }

  public function addToCartHandlerAction() 
  {
    if ($this->isFetch()) {
      // вытянуть джейсон
      $json = file_get_contents('php://input');
      $data = json_decode($json);
      // вытянуть переданный id товара
      $product_id = $data->productId;

      // добавление товара
      if(empty($_SESSION["user"])) {
        // не авторизован - кука
      } else {
        // авторизован - БД
        $res = $this->model->add_to_cart($_SESSION['user'], $product_id);
        
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