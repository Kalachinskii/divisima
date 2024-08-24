<?
namespace app\controllers;

use app\core\Controller;

class SearchController extends Controller
{
  public function indexAction()
  {
    $search = $_GET['product'];
    $searched = $this->model->search_products($search);
    $data = compact('searched', 'search');
    $this->view->render((object) $data);
  }


}