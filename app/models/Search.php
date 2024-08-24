<?
namespace app\models;

use app\core\Model;

class Search extends Model
{

  public function search_products($search)
  {
    $search = "%" . $search . "%";
    return $this->db->custom_query("SELECT * FROM products WHERE name LIKE ?", [$search]);
  }
}