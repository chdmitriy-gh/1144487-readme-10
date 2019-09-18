<?php

require_once('helpers.php');
require_once('DBConnection.php');
date_default_timezone_set('Europe/Moscow');

$is_auth = rand(0, 1);
$user_name = 'Дмитрий'; // укажите здесь ваше имя
$cards_lim = '6';
$filter_id = '';

/**
 * функция форматирования текста перед выводом
 **/
function format_text($text, $cut_limit=300) 
{
    $output = '';
    $text = strip_tags($text);

    if (mb_strlen($text) < $cut_limit) {
        $output = sprintf('<p>%s</p>', $text);
    } else {
        $text_array = explode(' ', $text); 
        $output_array = []; 
        $index = 0; 
        $cur_len = mb_strlen($text_array[0]); 
     
        while ($cur_len++ <= $cut_limit) {
            $output_array[] = $text_array[$index];
            $cur_len += mb_strlen($text_array[++$index]);            
        }
        
        $output = sprintf(
            '<p>%s...</p><a class="post-text__more-link" href="#">Читать далее</a>', 
            implode(' ', $output_array)
        );
    }

    return $output; 
}

/**
* Функция определения размера изображения для кнопки фильтра типов контента
**/
function type_icon_size($curr_type) 
{
    $icon_size = ['width' => '0', 'height' => '0'];

    switch (true) {
        case ($curr_type['class_name'] === 'photo') :
            return $icon_size = ['width' => '22', 'height' => '18'];
            
        case ($curr_type['class_name'] === 'video') :
            return $icon_size = ['width' => '24', 'height' => '16'];
                    
        case ($curr_type['class_name'] === 'text') :
            return $icon_size = ['width' => '20', 'height' => '21'];
            
        case ($curr_type['class_name'] === 'quote') :
            return $icon_size = ['width' => '21', 'height' => '20'];
            
        case ($curr_type['class_name'] === 'link') :
            return $icon_size = ['width' => '21', 'height' => '18'];
    }
}

$sql = 'SELECT id, type_name, class_name FROM types';
$res = mysqli_query($con, $sql);

if (is_sql_ok($res)) {
    $types = mysqli_fetch_all($res, MYSQLI_ASSOC);    
} 

if (isset($_GET['id'])) {
    $filter_id = intval($_GET['id']);
    $sql = 'SELECT cards.id, cards.creation_date, title, text_content, quote_auth, photo_path, video_path, link_path, 
        show_count, users.username, users.avatar_path, types.class_name, types.type_name FROM cards 
        JOIN users ON cards.user_id = users.id 
        JOIN types ON cards.type_id = types.id WHERE cards.type_id = ' . $filter_id . '
        ORDER BY show_count DESC LIMIT ' . $cards_lim;
} else {
    $sql = 'SELECT cards.id, cards.creation_date, title, text_content, quote_auth, photo_path, video_path, link_path, 
        show_count, users.username, users.avatar_path, types.class_name, types.type_name FROM cards 
        JOIN users ON cards.user_id = users.id 
        JOIN types ON cards.type_id = types.id ORDER BY show_count DESC LIMIT ' . $cards_lim;
}

$res = mysqli_query($con, $sql);

if (is_sql_ok($res)) {
    $cards = mysqli_fetch_all($res, MYSQLI_ASSOC);    
}

foreach ($cards as $key => $value)  {
    $cards[$key]['creation_date'] = generate_random_date($key);
}

$page_content = include_template('main.php', ['cards' => $cards, 'types' => $types, 'filter_id' => $filter_id]);
$layout_content = include_template('layout.php', 
    ['content' => $page_content, 'user_name' => $user_name, 'page_name' => 'readme: популярное', 'is_auth' => $is_auth]);

print($layout_content);
?>