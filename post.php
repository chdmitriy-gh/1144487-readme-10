<?php

require_once('helpers.php');
require_once('DBConnection.php');

$card_id='';
$is_auth = rand(0, 1);
$user_name = 'Дмитрий'; // укажите здесь ваше имя

/**
 * функция подсчета количества публикаций постов автора
 **/
function get_publ_num($con, $id) {
    $sql = 'SELECT id FROM cards WHERE user_id = ' . $id;
    $res = mysqli_query($con, $sql);

    if (is_sql_ok($res)) {
        return mysqli_num_rows($res);    
    }
}

/**
 * функция подсчета количества подписчиков автора
 **/
function get_subscr_num($con, $id) {
    $sql = 'SELECT id FROM subscribes WHERE subscribed_id = ' . $id;
    $res = mysqli_query($con, $sql);

    if (is_sql_ok($res)) {
        return mysqli_num_rows($res);    
    }
}

/**
 * функция подсчета количества комментариев для поста
 **/
function get_comments_num($con, $id) {
    $sql = 'SELECT id FROM comments WHERE card_id = ' . $id;
    $res = mysqli_query($con, $sql);

    if (is_sql_ok($res)) {
        return mysqli_num_rows($res);    
    }   
}

try {

    if (!isset($_GET['id'])) {
        throw new Exception('Не задан идентификатор поста');
    }

    $card_id = intval($_GET['id']);

    $sql = 'SELECT cards.id, cards.creation_date, title, text_content, quote_auth, photo_path, video_path, link_path, 
        show_count, user_id, users.username, users.avatar_path, users.creation_date AS user_date, types.class_name, types.type_name FROM cards 
        JOIN users ON cards.user_id = users.id 
        JOIN types ON cards.type_id = types.id WHERE cards.id = ' . $card_id;
    $res = mysqli_query($con, $sql);

    if (is_sql_ok($res)) {
        $card = mysqli_fetch_assoc($res);
    }

    if (!isset($card['id'])) {
        throw new Exception('Не найден пост с заданным идентификатором');
    }

    $years = floor((strtotime('now') - strtotime($card['user_date']))/31536000);
        
    if ($years < 1) {
        $years_on_site = 'менее года';
    } else {
        $years_on_site = $years . get_noun_plural_form($years, ' год', ' года', ' лет');
    }
    
    $publ_num = get_publ_num($con, $card['user_id']);        
    $subscr_num = get_subscr_num($con, $card['user_id']);
    $comments_num = get_comments_num($con, $card['id']);
    
    $sql = 'SELECT comments.id, comments.creation_date, content, username, avatar_path FROM comments
        JOIN users ON user_id = users.id
        WHERE card_id = ' . $card['id'] . ' ORDER BY creation_date ASC LIMIT 2';
    $res = mysqli_query($con, $sql);

    if (is_sql_ok($res)) {
        $comments = mysqli_fetch_all($res, MYSQLI_ASSOC);    
    }        
    
    $page_content = include_template('post-details.php', [
        'card' => $card, 'card_id' => $card_id, 'publ_num' => $publ_num, 'subscr_num' => $subscr_num, 
        'years_on_site' => $years_on_site, 'comments_num' => $comments_num, 'comments' => $comments]);
    $layout_content = include_template('layout.php', 
        ['content' => $page_content, 'user_name' => $user_name, 'page_name' => $card['title'], 'is_auth' => $is_auth]);

    print($layout_content);

} catch (Exception $NotFoundResultException) {
    $page_content = '<h2>Ошибка 404: Страница не найдена. ' . $NotFoundResultException->getMessage() . '</h2>';
    $layout_content = include_template('layout.php', 
        ['content' => $page_content, 'user_name' => $user_name, 'page_name' => 'Ошибка 404', 'is_auth' => $is_auth]);

    print($layout_content);
}

?>