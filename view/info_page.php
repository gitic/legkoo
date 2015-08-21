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

<div id="breadcrumbs">
    <div id="breadcrumbsBody">
        <a href="<?=PATH?>">главная</a> / <?=$infopage->title?>
    </div>
</div>

<div id="content">
    <div id="info">
        <h1><?=$infopage->title?></h1>
    </div>
</div>
