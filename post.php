<?php

require_once('helpers.php');
require_once('DBConnection.php');

$card_id='';
$dirname = pathinfo(__DIR__, PATHINFO_BASENAME);
$is_auth = rand(0, 1);
$user_name = 'Дмитрий'; // укажите здесь ваше имя

if (isset($_GET['id'])) {
    $card_id = $_GET['id'];

    $sql = 'SELECT cards.id, cards.creation_date, title, text_content, quote_auth, photo_path, video_path, link_path, 
        show_count, user_id, users.username, users.avatar_path, users.creation_date AS user_date, types.class_name, types.type_name FROM cards 
        JOIN users ON cards.user_id = users.id 
        JOIN types ON cards.type_id = types.id WHERE cards.id = ' . $card_id;
    $res = mysqli_query($con, $sql);

    if (!$res) {
        $error = mysqli_error($con);
        print('Ошибка MySQL: ' . $error);
        exit;
    }

    $card = mysqli_fetch_all($res, MYSQLI_ASSOC);

    if (isset($card[0]['id'])) {
        $years = floor((strtotime('now') - strtotime($card[0]['user_date']))/31536000);
        
        if ($years < 1) {
            $years_on_site = 'менее года';
        } else {
            $years_on_site = $years . get_noun_plural_form($years, ' год', ' года', ' лет');
        }

        $sql = 'SELECT COUNT(id) publ_num FROM cards WHERE user_id = ' . $card[0]['user_id'];
        $res = mysqli_query($con, $sql);

        if (!$res) {
            $error = mysqli_error($con);
            print('Ошибка MySQL: ' . $error);
            exit;
        }

        $publ_num = mysqli_fetch_all($res, MYSQLI_ASSOC);

        $sql = 'SELECT COUNT(id) subscr_num FROM subscribes WHERE subscribed_id = ' . $card[0]['user_id'];
        $res = mysqli_query($con, $sql);

        if (!$res) {
            $error = mysqli_error($con);
            print('Ошибка MySQL: ' . $error);
            exit;
        }

        $subscr_num = mysqli_fetch_all($res, MYSQLI_ASSOC);

        $sql = 'SELECT COUNT(id) comments_num FROM comments WHERE card_id = ' . $card[0]['id'];
        $res = mysqli_query($con, $sql);

        if (!$res) {
            $error = mysqli_error($con);
            print('Ошибка MySQL: ' . $error);
            exit;
        }

        $comments_num = mysqli_fetch_all($res, MYSQLI_ASSOC);

        $sql = 'SELECT comments.id, comments.creation_date, content, username, avatar_path FROM comments
            JOIN users ON user_id = users.id
            WHERE card_id = ' . $card[0]['id'] . ' ORDER BY creation_date ASC LIMIT 2';
        $res = mysqli_query($con, $sql);

        if (!$res) {
            $error = mysqli_error($con);
            print('Ошибка MySQL: ' . $error);
            exit;
        }

        $comments = mysqli_fetch_all($res, MYSQLI_ASSOC);
        
        $page_content = include_template('post-details.php', [
            'card' => $card, 'dirname' => $dirname, 'card_id' => $card_id, 'publ_num' => $publ_num, 'subscr_num' => $subscr_num, 
            'years_on_site' => $years_on_site, 'comments_num' => $comments_num, 'comments' => $comments]);
        $layout_content = include_template('layout.php', 
            ['content' => $page_content, 'user_name' => $user_name, 'page_name' => $card[0]['title'], 'is_auth' => $is_auth]);

        print($layout_content);
    } else {
        $page_content = '<h1>Ошибка 404: Страница не найдена</h1>';
        $layout_content = include_template('layout.php', 
        ['content' => $page_content, 'user_name' => $user_name, 'page_name' => 'Ошибка 404', 'is_auth' => $is_auth]);

        print($layout_content);    
    }
} else {
    $page_content = '<h1>Ошибка 404: Страница не найдена</h1>';
    $layout_content = include_template('layout.php', 
        ['content' => $page_content, 'user_name' => $user_name, 'page_name' => 'Ошибка 404', 'is_auth' => $is_auth]);

    print($layout_content);
}

?>