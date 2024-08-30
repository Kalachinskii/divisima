<?
namespace app\core;

abstract class Model
{
  protected $db;
  public function __construct()
  {
    $this->db = new DB();
  }

  public function get_cart_qty($login) {
    $user = $this->db->fetchOne($login, "users", "login");
    $data = $this->db->custom_query("SELECT SUM(qty) AS qty FROM carts WHERE user_id={$user->id}");
    return $data[0]->qty;
  }

  // public function add_or_del_to_cart($login, $product_id, $method)
  // {
  //   $user = $this->db->fetchOne($login, "users", "login");
  //   $is_in_cart = $this->db->custom_query("SELECT product_id, qty FROM carts WHERE user_id=? AND product_id=?", [$user->id, $product_id]);

  //   // есть товар в карзине
  //   if (empty($is_in_cart)) {
  //     // У юзера в корзине еще нет такого товара
  //     return $this->db->custom_query("INSERT INTO carts (user_id, product_id, qty) VALUES (?,?,?)", [$user->id, $product_id, 1]);
  //   } else {
  //     switch ($method) {
  //       case 'del':
  //         $updated_qty = $is_in_cart[0]->qty - 1;
  //         break;
  //       case 'add':
  //         $updated_qty = $is_in_cart[0]->qty + 1;
  //         break;
  //     }
  //     return $this->db->custom_query("UPDATE carts SET qty={$updated_qty} WHERE user_id=? AND product_id=?", [$user->id, $product_id]);
  //   }
  // }

  public function current_to_cart($login, $product_id, $currentSqy)
  {
    $user = $this->db->fetchOne($login, "users", "login");
    return $this->db->custom_query("UPDATE carts SET qty={$currentSqy} WHERE user_id=? AND product_id=?", [$user->id, $product_id]);
  }

  public function add_to_cart($login, $product_id)
  {
    $user = $this->db->fetchOne($login, "users", "login");
    $is_in_cart = $this->db->custom_query("SELECT product_id, qty FROM carts WHERE user_id=? AND product_id=?", [$user->id, $product_id]);
    // есть товар в карзине
    if (empty($is_in_cart)) {
      // У юзера в корзине еще нет такого товара
      return $this->db->custom_query("INSERT INTO carts (user_id, product_id, qty) VALUES (?,?,?)", [$user->id, $product_id, 1]);
    } else {
      // колличетсо товаров
      $updated_qty = $is_in_cart[0]->qty + 1;
      return $this->db->custom_query("UPDATE carts SET qty={$updated_qty} WHERE user_id=? AND product_id=?", [$user->id, $product_id]);
    }
  }

  public function del_to_cart($login, $product_id)
  {
    $user = $this->db->fetchOne($login, "users", "login");
    $is_in_cart = $this->db->custom_query("SELECT product_id, qty FROM carts WHERE user_id=? AND product_id=?", [$user->id, $product_id]);

    if (empty($is_in_cart)) {
      return $this->db->custom_query("INSERT INTO carts (user_id, product_id, qty) VALUES (?,?,?)", [$user->id, $product_id, 1]);
    } else {
      $updated_qty = $is_in_cart[0]->qty - 1;
      return $this->db->custom_query("UPDATE carts SET qty={$updated_qty} WHERE user_id=? AND product_id=?", [$user->id, $product_id]);
    }
  }
}