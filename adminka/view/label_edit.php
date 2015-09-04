<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

$pageDir = 'labels';
if(!isset($_GET['id'])){
    die("Страница не найдена <br> <a href='?view=$pageDir'>назад</a>");
}
else{  
    $rowId = $_GET['id'];
}

//Обработка формы
if(isset($_POST['submit'])){
    $title = clear($conn, htmlentities($_POST['title'],ENT_QUOTES));
    $class = clear($conn, htmlentities($_POST['class'],ENT_QUOTES));
    $values = array(
        'title'=>$title,
        'class'=>$class
    );
    $success = Label::update($values, array('id'=>$rowId), $conn);
    if(!$success){
        die("Ошибка при обновлении <br> <a href='?view={$pageDir}'>назад</a>");
    }
    echo '<script type="text/javascript">window.location = "?view='.$pageDir.'"</script>';
    die();   
}
$label = new Label();
$label->getFomDb(array('id'=>$rowId), $conn);

?>
<script src="<?=VIEW?>js/productsJs.js"></script>

<h1>
        Редактирование метки товара
</h1>
<div id="content">
        <form id='edit_form' name="edit_form" action="" method="post" enctype="multipart/form-data">

            <div class="block">
                <label>Название</label>
                <input class="inp" id="title" name="title" style="width:494px" value="<?=$label->title?>" placeholder="Название метки" required />
            </div>
            <div class="block">
                <label>Класс</label>
                <input class="inp" id="class" name="class" style="width:494px" value="<?=$label->class?>" placeholder="Класс метки" required />
            </div>
           
            <div id="bottom-btn">
                <input name="id" type="hidden" value="">
                <input name="submit" type="submit" value="сохранить" />
                <a href="?view=<?=$pageDir?>" class="cancel">отмена</a>
            </div>
            
        </form>
</div>
