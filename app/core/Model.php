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
}