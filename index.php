<?php
require_once('helpers.php');
date_default_timezone_set('Europe/Moscow');

$is_auth = rand(0, 1);
$user_name = 'Дмитрий'; // укажите здесь ваше имя

/**
 * функция форматирования текста перед выводом
 **/
function format_text($text, $cut_limit=300) {
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
function format_date($date) {
    $dt_date = date_create($date);
    $dt_now = date_create('now');
    $dt_diff = date_diff($dt_date, $dt_now);
    
    $days_intrv = date_interval_format($dt_diff, '%a');
    $hours_intrv = date_interval_format($dt_diff, '%h');
    $minutes_intrv = date_interval_format($dt_diff, '%i');

    if ($days_intrv > 35) {
        $months_intrv = ceil($days_intrv / 31);
        $output = $months_intrv . get_noun_plural_form($months_intrv, ' месяц', ' месяца', ' месяцев') . ' назад'; 
    } elseif ($days_intrv > 7) {
        $weeks_intrv = ceil($days_intrv / 7);
        $output = $weeks_intrv . get_noun_plural_form($weeks_intrv, ' неделя', ' недели', ' недель') . ' назад'; 
    } elseif ($days_intrv >= 1) {
        $output = $days_intrv . get_noun_plural_form($days_intrv, ' день', ' дня', ' дней') . ' назад';         
    } elseif ($hours_intrv >= 1) {
        $output = $hours_intrv . get_noun_plural_form($hours_intrv, ' час', ' часа', ' часов') . ' назад';
    } else {
        $output = $minutes_intrv . get_noun_plural_form($minutes_intrv, ' минута', ' минуты', ' минут') . ' назад';
    }

    return $output;
}

/**
* Функция преобразования формата даты для тега title
**/
function format_date_title($date) {
    $dt_date = date_create($date);
    $output = date_format($dt_date, 'd.m.Y H:i');
    return $output;
}

$cards = [
    [
        'header' => 'Цитата',
        'type' => 'post-quote',
        'content' => 'Мы в жизни любим только раз, а после ищем лишь похожих',
        'author-name' => 'Лариса',
        'author-avatar' => 'userpic-larisa-small.jpg'
    ],
    [
        'header' => 'Игра престолов',
        'type' => 'post-text',
        'content' => 'Не могу дождаться начала финального сезона своего любимого сериала!',
        'author-name' => 'Владик',
        'author-avatar' => 'userpic.jpg'
    ],
    [
        'header' => 'Наконец, обработал фотки!',
        'type' => 'post-photo',
        'content' => 'rock-medium.jpg',
        'author-name' => 'Виктор',
        'author-avatar' => 'userpic-mark.jpg'
    ],
    [
        'header' => 'Полезный пост про Байкал',
        'type' => 'post-text',
        'content' => 'Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы. Байкал 
        считается самым глубоким озером в мире. Он окружен сетью пешеходных маршрутов, называемых
        Большой байкальской тропой. Деревня Листвянка, расположенная на западном берегу озера, –
        популярная отправная точка для летних экскурсий. Зимой здесь можно кататься на коньках и
        собачьих упряжках.',
        'author-name' => 'Лариса',
        'author-avatar' => 'userpic-larisa-small.jpg'
    ],
    [
        'header' => 'Моя мечта',
        'type' => 'post-photo',
        'content' => 'coast-medium.jpg',
        'author-name' => 'Лариса',
        'author-avatar' => 'userpic-larisa-small.jpg'
    ],
    [
        'header' => 'Лучшие курсы',
        'type' => 'post-link',
        'content' => 'www.htmlacademy.ru',
        'author-name' => 'Владик',
        'author-avatar' => 'userpic.jpg'
    ]
];

foreach ($cards as $key => $value)  {
    $cards[$key]['date'] = generate_random_date($key);
}

$page_content = include_template('main.php', ['cards' => $cards]);
$layout_content = include_template('layout.php', 
    ['content' => $page_content, 'user_name' => $user_name, 'page_name' => 'readme: популярное', 'is_auth' => $is_auth]);

print($layout_content);
?>