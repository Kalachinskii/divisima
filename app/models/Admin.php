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

  public function check_is_admin($login)
  {
    return $this->db->custom_query("SELECT * FROM users WHERE login = '$login' AND role_id = 2");
  }

  public function check_user_password($id, $password)
  {
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

  public function get_product($id)
  {
    // return $this->db->custom_query("SELECT p.id, p.image, p.name, p.price, c.qty FROM carts c JOIN products p ON c.product_id = p.id WHERE c.user_id = {$user->id}");
    return $this->db->custom_query("SELECT products.*, categories.name AS category_name FROM categories JOIN products ON products.category_id = categories.id WHERE products.id = $id");
  }
  public function get_categorie_id($productId)
  {
    return $this->db->custom_query("SELECT category_id FROM products WHERE id = $productId");
  }
  public function get_categories_not_id($id)
  {
    return $this->db->custom_query("SELECT * FROM categories WHERE id != $id");
  }

  public function get_categories()
  {
    return $this->db->custom_query("SELECT * FROM categories");
  }

  public function deleteProduct($data)
  {
    return $this->db->custom_query("DELETE FROM products WHERE `id` = '$data->productId'");
  }

  public function add_new_category($data)
  {
    $this->db->custom_query("INSERT INTO `categories` (`name`) VALUES (?)", [$data->categorie]);
  }

  public function add_new_product($data)
  {
    $this->db->custom_query("  INSERT INTO `products` 
  (`name`, `price`, `image`, `category_id`, `discount`, `description`, `count`, `hot`)
  VALUES (?,?,?,?,?,?,?,?)", [$data->name, $data->price, $data->imageName, '1', $data->discount, $data->textarea, $data->count, '0']);
  }
  // $data->category - id нужен

  public function set_product($data)
  {
    $this->db->custom_query("UPDATE products SET `hot` = '$data->hot', `description` = '$data->textarea', `name` = '$data->name', `image` = '$data->imageName', `price` = '$data->price', `category_id` = '$data->category', `discount` = $data->discount, `count` = '$data->count' WHERE id = '$data->idProducts'");
  }

  public function get_users()
  {
    return $this->db->custom_query("
    SELECT 
        users.login,
        users.id,
        SUM(carts.qty) as sum_products
    FROM 
        users
    LEFT JOIN 
        carts ON carts.user_id = users.id
    WHERE 
        users.role_id = 1
    GROUP BY 
        users.login, users.id;
    ");
    // return $this->db->custom_query("SELECT login,id FROM users WHERE role_id=1");
  }

  public function get_count_users()
  {
    return $this->db->custom_query("SELECT COUNT(*) as count FROM users WHERE role_id=1");
  }

  public function get_count_products()
  {
    return $this->db->custom_query("SELECT COUNT(*) as count FROM products");
  }

  public function get_count_products_user($idUser)
  {
    return $this->db->custom_query("SELECT COUNT(*) as count FROM products WHERE user_id = id");
  }

  public function get_user_products($userId)
  {
    return $this->db->custom_query("SELECT products.name as name, products.price as price, carts.qty as qty 
    FROM users 
    JOIN carts ON carts.user_id = users.id 
    JOIN products ON carts.product_id = products.id
    WHERE users.id = $userId");
  }

  public function delete_user($userId)
  {
    return $this->db->custom_query(
      "START TRANSACTION;
      DELETE FROM carts WHERE user_id = $userId;
      DELETE FROM favourites WHERE user_id = $userId;
      DELETE FROM users WHERE id = $userId;
      COMMIT;"
    );
  }

  public function delete_category_id($id)
  {
    return $this->db->custom_query("DELETE FROM categories WHERE `id` = $id");
  }

  public function get_products_by_search($data)
  {
    return $this->db->custom_query("
      SELECT p.*, categories.name AS category_name 
      FROM $data->table p 
      JOIN categories ON p.category_id = categories.id 
      WHERE p.name LIKE '%$data->content%'
    ");
  }

  public function get_users_by_search($data)
  {
    return $this->db->custom_query("
    SELECT 
        users.login,
        users.id,
        SUM(carts.qty) as sum_products
    FROM 
        $data->table
    LEFT JOIN 
        carts ON carts.user_id = users.id
    WHERE 
        users.role_id = 1
    AND
      users.login
    LIKE
      '%$data->content%'
    GROUP BY 
        users.login, users.id;
    ");
    // return $this->db->custom_query("SELECT login,id FROM users WHERE role_id=1");
  }
}
