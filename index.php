<?php
require_once('helpers.php');
require_once('connect.php');
date_default_timezone_set('Europe/Moscow');

$is_auth = rand(0, 1);
$user_name = 'Дмитрий'; // укажите здесь ваше имя
$cards_lim = '6';

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
* Функция форматирования даты поста
**/
function format_date($date) 
{
    $minutes_intrv = floor((strtotime('now') - strtotime($date))/60);

    switch (true) {
        case ($minutes_intrv < 60) :
            $output = $minutes_intrv . get_noun_plural_form($minutes_intrv, ' минута', ' минуты', ' минут');
            break;

        case ($minutes_intrv < 1440) :
            $output = floor($minutes_intrv / 60) . get_noun_plural_form(floor($minutes_intrv / 60), ' час', ' часа', ' часов');
            break;

        case ($minutes_intrv < 10080) :
            $output = floor($minutes_intrv / 1440) . get_noun_plural_form(floor($minutes_intrv / 1440), ' день', ' дня', ' дней');
            break;

        case ($minutes_intrv < 50400) :
            $output = floor($minutes_intrv / 10080) . get_noun_plural_form(floor($minutes_intrv / 10080), ' неделя', ' недели', ' недель');
            break;

        default :
            $output = floor($minutes_intrv / 43200) . get_noun_plural_form(floor($minutes_intrv / 43200), ' месяц', ' месяца', ' месяцев');
    }
    
    return $output . ' назад'; 
}

/**
* Функция преобразования формата даты для тега title
**/
function format_date_title($date) 
{
    return date_format(date_create($date), 'd.m.Y H:i');
}

/**
* Функция определения размера изображения для кнопки фильтра типов контента
**/
function type_icon_size($curr_type) 
{
    $icon_size = ['width' => '0', 'height' => '0'];
    switch (true) {
        case ($curr_type['class_name'] === 'photo') :
            $icon_size['width'] = '22';
            $icon_size['height'] = '18';
            break;

        case ($curr_type['class_name'] === 'video') :
            $icon_size['width'] = '24';
            $icon_size['height'] = '16';
            break;
        
        case ($curr_type['class_name'] === 'text') :
            $icon_size['width'] = '20';
            $icon_size['height'] = '21';
            break;

        case ($curr_type['class_name'] === 'quote') :
            $icon_size['width'] = '21';
            $icon_size['height'] = '20';
            break;

        case ($curr_type['class_name'] === 'link') :
            $icon_size['width'] = '21';
            $icon_size['height'] = '18';
            break;
    }

    return $icon_size;
}


$sql = 'SELECT type_name, class_name FROM types';
$res = mysqli_query($con, $sql);
if (!$res) {
    $error = mysqli_error($con);
    print('Ошибка MySQL: ' . $error);
    exit;
} 
$types = mysqli_fetch_all($res, MYSQLI_ASSOC);

$sql = 'SELECT cards.id, cards.creation_date, title, text_content, quote_auth, photo_path, video_path, link_path, 
    show_count, users.username, users.avatar_path, types.class_name, types.type_name FROM cards 
    JOIN users ON cards.user_id = users.id 
    JOIN types ON cards.type_id = types.id 
    ORDER BY show_count DESC LIMIT ' . $cards_lim;    
$res = mysqli_query($con, $sql);
if (!$res) {
    $error = mysqli_error($con);
    print('Ошибка MySQL: ' . $error);
    exit;
}
$cards = mysqli_fetch_all($res, MYSQLI_ASSOC);

foreach ($cards as $key => $value)  {
    $cards[$key]['creation_date'] = generate_random_date($key);
}

$page_content = include_template('main.php', ['cards' => $cards, 'types' => $types]);
$layout_content = include_template('layout.php', 
    ['content' => $page_content, 'user_name' => $user_name, 'page_name' => 'readme: популярное', 'is_auth' => $is_auth]);

print($layout_content);
?>