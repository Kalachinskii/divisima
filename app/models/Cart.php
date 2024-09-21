<?

namespace app\models;

use app\core\Model;

class Cart extends Model
{

  public function get_cart($login)
  {
    $user = $this->db->fetchOne($login, "users", "login");
    return $this->db->custom_query("SELECT p.id, p.image, p.name, p.price, p.discount, c.qty FROM carts c JOIN products p ON c.product_id = p.id WHERE c.user_id = {$user->id}");
  }

  // получение информации о товарах в карзине не авторизованного пользователя
  // [id товара => его колличество]
  public function get_cart_no_name($cart)
  {
    $arr_product_id = array_keys($cart);
    $str_product_id = implode(",", $arr_product_id);
    $arr_obj_products = $this->db->custom_query("SELECT image, name, price, id, discount FROM products WHERE id IN ($str_product_id)");

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

  // public function add_to_cart($login, $product_id)
  // {
  //   $user = $this->db->fetchOne($login, "users", "login");
  //   $is_in_cart = $this->db->custom_query("SELECT product_id, qty FROM carts WHERE user_id=? AND product_id=?", [$user->id, $product_id]);

  //   // есть товар в карзине
  //   if (empty($is_in_cart)) {
  //     // У юзера в корзине еще нет такого товара
  //     return $this->db->custom_query("INSERT INTO carts (user_id, product_id, qty) VALUES (?,?,?)", [$user->id, $product_id, 1]);
  //   } else {
  //     // колличетсо товаров
  //     $updated_qty = $is_in_cart[0]->qty + 1;

  //     return $this->db->custom_query("UPDATE carts SET qty={$updated_qty} WHERE user_id=? AND product_id=?", [$user->id, $product_id]);
  //   }
  // }
}
