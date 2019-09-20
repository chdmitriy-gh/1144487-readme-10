<?php

require_once('helpers.php');
require_once('DBConnection.php');
require_once('PostDataHelpers.php');

$is_auth = rand(0, 1);
$user_name = 'Дмитрий'; // укажите здесь ваше имя
$comments_lim = '2';

try {

    if (!isset($_GET['id'])) {
        throw new Exception('Не задан идентификатор поста');
    }
    
    $sql = 'SELECT cards.id, cards.creation_date, title, text_content, quote_auth, photo_path, video_path, link_path, 
        show_count, user_id, users.username, users.avatar_path, users.creation_date AS user_date, types.class_name, types.type_name FROM cards 
        JOIN users ON cards.user_id = users.id 
        JOIN types ON cards.type_id = types.id WHERE cards.id = ?';        
    $res = mysqli_prepare($con, $sql);
    $stmt = db_get_prepare_stmt($con, $sql, [$_GET['id']]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

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
        WHERE card_id = ' . $card['id'] . ' ORDER BY creation_date ASC LIMIT ' . $comments_lim;
    $res = mysqli_query($con, $sql);

    if (is_sql_ok($res)) {
        $comments = mysqli_fetch_all($res, MYSQLI_ASSOC);    
    }        
    
    $page_content = include_template('post-details.php', [
        'card' => $card, 'publ_num' => $publ_num, 'subscr_num' => $subscr_num, 
        'years_on_site' => $years_on_site, 'comments_num' => $comments_num, 'comments' => $comments]);
    $layout_content = include_template('layout.php', 
        ['content' => $page_content, 'user_name' => $user_name, 'page_name' => $card['title'], 'is_auth' => $is_auth]);

    print($layout_content);
} catch (Exception $e) {
    $page_content = '<h2>Ошибка 404: Страница не найдена. ' . $e->getMessage() . '</h2>';
    $layout_content = include_template('layout.php', 
        ['content' => $page_content, 'user_name' => $user_name, 'page_name' => 'Ошибка 404', 'is_auth' => $is_auth]);

    print($layout_content);
}

?>