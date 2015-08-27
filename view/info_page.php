<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
// Запрос в Controller
?>

<div id="breadcrumbs">
    <div id="breadcrumbsBody">
        <a href="<?=PATH?>">главная</a> / <?=$infopage->title?>
    </div>
</div>

<div id="content">
    <div id="info">
        <h1><?=$infopage->title?></h1>
        <div class="text">
            <?=$infopage->text?>
        </div>
    </div>
</div>
