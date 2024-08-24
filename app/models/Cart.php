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