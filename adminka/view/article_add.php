<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $date = date('Y-m-d H:i:s');
    $newArticle = new Article();
    $newArticle->title = mb_ucfirst($title);
    $newArticle->translit = mb_strtolower(translitIt($title));
    $newArticle->visible = 0;
    $newArticle->category = 0;
    $newArticle->date_add = $date;
    $succes = $newArticle->insert($conn);
    if($succes){
        $id = $conn->insert_id;
        echo '<script type="text/javascript">window.location = "?view=article_edit&id='.$id.'"</script>';
    }
    else{
        echo 'Ошибка при записи в бд';
    }
    
}
?>
<h1>
        Добавить новую статью(новость)
</h1>
<div id="content">
        <form action="" method="post">
                <div class="block">
                        <input class="inp" id="title" name="title" style="width:550px" placeholder="Название статьи(новости)" required/>
                        <input name='submit' class="btn-save" type="submit" value="добавить"/>
                </div>
        </form>
</div>
