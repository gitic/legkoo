<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

if(isset($_POST['type'])){
    $type = $_POST['type'];
    switch ($type) {
        case 'translit':
            $str = $_POST['str'];
            $tStr = mb_strtolower(translitIt($str));
            die($tStr);
            break;
    }
}
