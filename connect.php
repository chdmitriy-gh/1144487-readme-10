<?php
$con = mysqli_connect('localhost', 'root', '', 'readme');
if (!$con) {
    print('Ошибка подключения: ' . mysqli_connect_error());
    exit;
} 
mysqli_set_charset($con, 'utf8'); 
