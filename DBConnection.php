<?php
require_once('config.php');

$con = mysqli_connect(db_host, db_user, db_passw, db_name);
if (!$con) {
    print('Ошибка подключения: ' . mysqli_connect_error());
    exit;
} 
mysqli_set_charset($con, 'utf8'); 
