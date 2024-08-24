<?
namespace app\models;

use app\core\Model;

class Main extends Model
{
  public function get_banners()
  {
    return $this->db->custom_query("SELECT url_name FROM assets WHERE type_id=1");
  }
  public function get_features()
  {
    return $this->db->custom_query("SELECT url_name FROM assets WHERE type_id=2");
  }

  public function get_categories()
  {
    return $this->db->fetchAll('categories');
  }

  public function get_products($start, $limit)
  {
    return $this->db->custom_query("SELECT * FROM products LIMIT {$limit} OFFSET {$start}");
  }

  public function get_category_products($category_id, $start, $limit)
  {
    return $this->db->custom_query("SELECT * FROM products WHERE category_id=? LIMIT {$limit} OFFSET {$start}", [$category_id]);
  }

  public function get_hot_products($hot)
  {
    return $this->db->custom_query("SELECT * FROM products WHERE hot>={$hot}");
  }

  public function add_to_favourites($login, $product_id)
  {
    $user = $this->db->fetchOne($login, "users", "login");
    $is_in_favourites = $this->db->custom_query("SELECT product_id FROM favourites WHERE user_id=? AND product_id=?", [$user->id, $product_id]);
    if (empty($is_in_favourites)) {
      return $this->db->custom_query("INSERT INTO favourites (product_id, user_id) VALUES (?,?)", [$product_id, $user->id]);
    } else {
      return true;
    }
  }

  public function delete_from_favourites($login, $product_id)
  {
    $user = $this->db->fetchOne($login, "users", "login");
    return $this->db->custom_query("DELETE FROM favourites WHERE user_id=? AND product_id=?", [$user->id, $product_id]);
  }

  public function get_favorite_products($login)
  {
    $user = $this->db->fetchOne($login, "users", "login");
    return $this->db->custom_query("SELECT product_id FROM favourites WHERE user_id={$user->id}");
  }

  public function add_to_cart($login, $product_id) {
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

  public function get_cart_qty($login) {
    $user = $this->db->fetchOne($login, "users", "login");
    $data = $this->db->custom_query("SELECT SUM(qty) AS qty FROM carts WHERE user_id={$user->id}");
    return $data[0]->qty;
  }
}