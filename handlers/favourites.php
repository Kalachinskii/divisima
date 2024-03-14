<?php
// $db = include_once 'utils/db.php';
// // ответ на фетчь запрос приходит с помощью echo 
// $status = 'ok';
// echo $status;  //работает и без него

// поймать JS запрос и получим ссылку и категорию
$data = file_get_contents("php://input");
// сначала проверка на содержимое
if (!empty($data)) {
    // распокаовать в массив (без тру будет объект Object {"url" => "ok"} с обращением data->url)
    $data = json_decode($data, true);
    // должен быть доп параметр для вызова нужной функции
    if ($data['param'] === 'add_favourite') {
        // add_favourite($data);
    }
}
// ответ на фетчь запрос приходит с помощью echo
// echo $data;



// if ($db == false) {
//     die('Ошибка подключение к БД');
// }

// if (isset($_GET['url']) and !empty($_GET['url']) and isset($_GET['category']) and !empty($_GET['category'])) {
//     $category = $_GET['category'];
//     $url = $_GET["url"];
//     $key = array_search($url, array_column($data[$category], 'url'));

//     if (!$key) {
//         die();
//     }
//     $post = $data[$category][$key];


    // ЗАПРОС с помощью PHP
    /*
    function add_favourite(&$pdo, &$post)
    {
        // обозначенные ключи через :имя
        $stmt = $pdo->prepare("INSERT INTO favourites (author,title,description,url,urlToImage,publishedAt,content) VALUES (:author, :title, :description, :url, :urlToImage, :publishedAt, :content)");
        $stmt->execute([
            'author' => $post['author'],
            'title' => $post['title'],
            'description' => $post['description'],
            'url' => $post['url'],
            'urlToImage' => $post['urlToImage'],
            'publishedAt' => $post['publishedAt'],
            'content' => $post['content'],
        ]);
        // убрать повторы (НЕРАБОТАЕТ)
        header('Location: ' . $_SERVER['HTTP_SELF']);
    }

    add_favourite($db, $post);
    */



    // ЗАПРОС с помощью JS

// }
