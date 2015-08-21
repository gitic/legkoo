<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

if(!isset($_GET['id'])){
    die('Страница не найдена');
}
$id=$_GET['id'];
$infopage = new Infopage();
$infopage->getFomDb(array('id'=>$id), $conn);

?>


<h1><?=$infopage->title?></h1>