<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $date = date('Y-m-d H:i:s');
    $newInfoPage = new Infopage();
    $newInfoPage->title = mb_ucfirst($title);
    $newInfoPage->translit = mb_strtolower(translitIt($title));
    $newInfoPage->visible = 0;
    $newInfoPage->date_add = $date;
    $succes = $newInfoPage->insert($conn);
    if($succes){
        $id = $conn->insert_id;
        echo '<script type="text/javascript">window.location = "?view=info_page_edit&id='.$id.'"</script>';
    }
    else{
        echo 'Ошибка при записи в бд';
    }
    
}
?>
<h1>
        Добавить новую страницу
</h1>
<div id="content">
        <form action="" method="post">
                <div class="block">
                        <input class="inp" id="title" name="title" style="width:550px" placeholder="Название страницы" required/>
                        <input name='submit' class="btn-save" type="submit" value="добавить"/>
                </div>
        </form>
</div>
