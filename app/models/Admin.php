<?
namespace app\models;

use app\core\Model;

class Admin extends Model
{
  private $table = 'users';

  public function check_is_user($login)
  {
    return $this->db->fetchOne($login, $this->table, 'login');
  }

  public function check_user_password($id, $password) {
    $password_hash = $this->db->custom_query("SELECT password FROM {$this->table} WHERE id={$id}");
    // password_hash - return массив с объектами
    if ($password_hash[0]->password) {
      return password_verify($password, $password_hash[0]->password);
    // пароля нет
    } else {
      return false;
    }
  }

  public function get_products()
  {
    // return $this->db->custom_query("SELECT p.id, p.image, p.name, p.price, c.qty FROM carts c JOIN products p ON c.product_id = p.id WHERE c.user_id = {$user->id}");
    return $this->db->custom_query("SELECT products.*, categories.name AS category_name FROM categories JOIN products ON products.category_id = categories.id");
  }

  // переделать накнопку через фетчь
  public function get_users()
  {
    return $this->db->custom_query("SELECT login,id FROM users WHERE role_id=1");
  }

  public function get_count_users()
  {
    return $this->db->custom_query("SELECT COUNT(*) as count FROM users WHERE role_id=1");
  }

  public function get_count_products()
  {
    return $this->db->custom_query("SELECT COUNT(*) as count FROM products");
  }
/*
return $this->db->custom_query("SELECT users.login, products.name, products.price, carts.qty FROM users JOIN carts ON carts.user_id = users.id JOIN products ON carts.product_id = products.id");
  Array
(
    [0] => stdClass Object
        (
            [login] => Qwer1234
            [name] => Black jacket
            [price] => 35.00
            [qty] => 2
        )

    [1] => stdClass Object
        (
            [login] => Qwer1234
            [name] => Milk dreskot
            [price] => 53.00
            [qty] => 2
        )

    [2] => stdClass Object
        (
            [login] => Qwer1234
            [name] => Beach cover-up
            [price] => 43.00
            [qty] => 3
        )

    [3] => stdClass Object
        (
            [login] => Qwer1234
            [name] => Swimsuit black
            [price] => 32.00
            [qty] => 4
        )

    [4] => stdClass Object
        (
            [login] => Qwer1234
            [name] => Black Top
            [price] => 32.00
            [qty] => 5
        )

    [5] => stdClass Object
        (
            [login] => Qwer1234
            [name] => White jacket
            [price] => 32.00
            [qty] => 6
        )

    [6] => stdClass Object
        (
            [login] => ASdasd123
            [name] => Milk dreskot
            [price] => 53.00
            [qty] => 6
        )

    [7] => stdClass Object
        (
            [login] => ASdasd123
            [name] => White jacket
            [price] => 32.00
            [qty] => 4
        )

)
*/

}