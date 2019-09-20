<?php

/**
 * функция подсчета количества публикаций постов автора
 **/
function get_publ_num($con, $id) {
    $sql = 'SELECT COUNT(id) AS total_count FROM cards WHERE user_id = ' . $id;
    $res = mysqli_query($con, $sql);

    if (is_sql_ok($res)) {
        $total = mysqli_fetch_assoc($res);
        return $total['total_count'];
    }
}

/**
 * функция подсчета количества подписчиков автора
 **/
function get_subscr_num($con, $id) {
    $sql = 'SELECT COUNT(id) AS total_count FROM subscribes WHERE subscribed_id = ' . $id;
    $res = mysqli_query($con, $sql);

    if (is_sql_ok($res)) {
        $total = mysqli_fetch_assoc($res);
        return $total['total_count'];
    }
}

/**
 * функция подсчета количества комментариев для поста
 **/
function get_comments_num($con, $id) {
    $sql = 'SELECT COUNT(id) AS total_count FROM comments WHERE card_id = ' . $id;
    $res = mysqli_query($con, $sql);

    if (is_sql_ok($res)) {
        $total = mysqli_fetch_assoc($res);
        return $total['total_count'];
    }   
}
