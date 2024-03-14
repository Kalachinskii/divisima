<?
// ФАЙЛ ТОЛЬКО С ПОДКЛЮЧЕНИЕМ
$host = "localhost";
$dbname = "techblog";
$login = "root";
$password = "";

// debug($pdo); - выдаёт object значит всё ок/ уберём ошибки в случаее возникновения
try {
    $pdo = new PDO("mysql:host={$host};dbname={$dbname}", "{$login}", "{$password}");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // установка кодилровки utf8
    $pdo->exec("set names 'utf8'");
    return $pdo;
} catch (PDOException $err) {
    return false;
    die('Ошибка подключения к БД ' . $err->getMessage());
}
