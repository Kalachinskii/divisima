<?
// переменные
$data = [];
$categories = [
    'business',
    'entertainment',
    'general',
    'health',
    'science',
    'sports',
    'technology'
];

function request($categories)
{
    // открыть сессию
    $init = curl_init();

    curl_setopt($init, CURLOPT_URL, "https://saurav.tech/NewsAPI/top-headlines/category/" . $categories . "/in.json");
    curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($init, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($init, CURLOPT_FOLLOWLOCATION, true);
    $resp = curl_exec($init);
    $data = json_decode($resp, true);
    // закрыть сессию
    curl_close($init);
    return $data;
}

function get_data($categories, &$data)
{
    // из нее вызваеться выше функция - request
    foreach ($categories as $category) {
        $resp = request($category);
        if ($resp['status'] == 'ok') {
            $data[$category] = $resp['articles'];
        }
    }
    return $data;
}

// отрисовка
function debug($arr)
{
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}

function get_random_categories($max, $min = 0)
{
    $i = 0;
    $random_categories = [];

    while ($i < 3) {
        $random_category = rand($min, $max - 1);

        if (empty($random_categories) or !in_array($random_category, $random_categories)) {
            array_push($random_categories, $random_category);
            $i++;
        }
    }
    return $random_categories;
}

function get_random_posts($random_categories, $categories, $data)
{
    $random_posts = [];
    foreach ($random_categories as $category_ind) {
        //получаем имя категории
        $cat_name = $categories[$category_ind];
        // вытащить пост
        $cat_posts = $data[$cat_name];
        // debug($category_posts);
        // взять индекс рандомного поста по категории
        $post_ind = rand(0, count($cat_posts) - 1);
        $random_posts[$cat_name] = $cat_posts[$post_ind];
    }
    return $random_posts;
}

// получаем данные с сервера
get_data($categories, $data);
// получаем рандом категории
$random_categories = get_random_categories(count($data));
// debug($random_categories);
//получить рандомные посты
$posts = get_random_posts($random_categories, $categories, $data);
// debug($posts);
