<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

$pageDir = 'states';
if(!isset($_GET['id'])){
    die("Страница не найдена <br> <a href='?view=$pageDir'>назад</a>");
}
else{  
    $rowId = $_GET['id'];
}

//Обработка формы
if(isset($_POST['submit'])){
    $title = clear($conn, htmlentities($_POST['title'],ENT_QUOTES));
    $colour = clear($conn, htmlentities($_POST['colour'],ENT_QUOTES));
    $values = array(
        'title'=>$title,
        'colour'=>$colour
    );
    $success = State::update($values, array('id'=>$rowId), $conn);
    if(!$success){
        die("Ошибка при обновлении <br> <a href='?view={$pageDir}'>назад</a>");
    }
    echo '<script type="text/javascript">window.location = "?view='.$pageDir.'"</script>';
    die();   
}
$state = new State();
$state->getFomDb(array('id'=>$rowId), $conn);

?>
<script src="../lib/jpicker/jpicker-1.1.6.min.js"></script>
<link rel="Stylesheet" type="text/css" href="../lib/jpicker/css/jpicker-1.1.6.min.css" />
<link rel="Stylesheet" type="text/css" href="../lib/jpicker/jPicker.css" />
<script src="<?=VIEW?>js/statesJs.js"></script>
<h1>
        Редактирование статуса
</h1>
<div id="content">
        <form id='edit_form' name="edit_form" action="" method="post" enctype="multipart/form-data">

            <div class="block">
                <label>Название</label>
                <input class="inp" id="title" name="title" style="width:494px" value="<?=$state->title?>" placeholder="Название статуса" required />
            </div>
            
            <div class="block">
                <label>Цвет</label>
                <?php
                    if($state->colour == ''){
                        $colour = '39bc32';
                    }
                    else{$colour = $state->colour;}
                ?>
                <input id="Binded" name='colour' type="text" value="<?=$colour?>" />
            </div>
           
            <div id="bottom-btn">
                <input name="id" type="hidden" value="">
                <input name="submit" type="submit" value="сохранить" />
                <a href="?view=<?=$pageDir?>" class="cancel">отмена</a>
            </div>
            
        </form>
</div>
