<?

namespace app\core;
// общая логика для всех контролеров
class Controller
{
    // текущий маршрут
    protected $route;
    // за вид подключаемой страници определяемой маршрутом
    protected $view;
    // модель запросов
    protected $model;

    public function __construct($route)
    {
        $this->route = $route;
        $this->includ_model($route);
        $this->view = new View($route);
    }

    private function includ_model($route)
    {
        $model_name = '\app\models\\' . $route['controller'];
        if (class_exists($model_name)) {
            $this->model = new $model_name;
        } else {
            if (PROD) {
                // при ошибки в моделях типо не Main а Mains
                echo '<script> alert("Не удалось подключиться к БД"); </script>';
            } else {
                echo 'Модель не найдена: ' . $model_name;
            }
        }
    }
}
