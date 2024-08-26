<?
namespace app\models;

use app\core\Model;

class Cart extends Model
{

  public function get_cart($login)
  {
    $user = $this->db->fetchOne($login, "users", "login");

    return $this->db->custom_query("SELECT p.id, p.image, p.name, p.price, c.qty FROM carts c JOIN products p ON c.product_id = p.id WHERE c.user_id = {$user->id}");
  }

  // получение информации о товарах в карзине не авторизованного пользователя
  // [id товара => его колличество, 1 => 222, 23 => 4]
  public function get_cart_no_name($cart)
  {
    $arr_product_id = array_keys($cart);
    $str_product_id = implode(",", $arr_product_id);
    $arr_obj_products = $this->db->custom_query("SELECT image, name, price, id FROM products WHERE id IN ($str_product_id)");
    
    // добавляем свойство: qty(колличества товаров) по id
    foreach ($arr_obj_products as $key => $value) {
      foreach ($cart as $id_product => $qty) {
        if ($id_product == $value->id) {
          $value->qty = $qty;
        }
      }
    }

    return $arr_obj_products;
  }
}

// $products_ids = $this->db->custom_query("SELECT product_id, qty FROM carts WHERE user_id={$user->id}");
    
// $cart = [];
// foreach ($products_ids as $key => $value) {
//   $id = $value->product_id;
//   $product = $this->db->custom_query("SELECT name,price FROM products WHERE id={$id}");
//   $product[0]->qty = $value->qty;
//   array_push($cart, $product);
// }
// return $cart;

    // AS опустили = FROM carts AS c и JOIN products AS p
    // JOIN - оюъедение
    // ON - по условию (общее для 2 таблиц id = product_id)
    // WHERE где user_id = id условие