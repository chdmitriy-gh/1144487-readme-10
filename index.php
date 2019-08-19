<?php
require_once('helpers.php');

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

$page_content = include_template('main.php', ['cards' => $cards]);
$layout_content = include_template('layout.php', 
    ['content' => $page_content, 'user_name' => $user_name, 'page_name' => 'readme: популярное', 'is_auth' => $is_auth]);

print($layout_content);
?>