<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

if(isset($_POST['submit'])){
    $result = $conn->query("SELECT COUNT(*) FROM categories WHERE id_index='0'");
    $numRows = $result->fetch_row();
    $numRows = $numRows[0] + 1;
    $title = $_POST['name'];
    $newCategory = new Category();
    $newCategory->title = mb_ucfirst($title);
    $newCategory->visible = 1;
    $newCategory->translit = mb_strtolower(translitIt($title));
    $newCategory->position = $numRows;
    $succes = $newCategory->insert($conn);
    
    if($succes){
        $id = $conn->insert_id;
        echo '<script type="text/javascript">window.location = "?view=category_edit&id='.$id.'"</script>';
    }
    else{
        echo 'Ошибка при записи в бд';
    }
    
}
?>
<h1>
        Добавить новую категорию
</h1>
<div id="content">
        <form action="" method="post">
                <div class="block">
                        <input class="inp" id="name" name="name" style="width:550px" placeholder="Название категории" required/>
                        <input name='submit' class="btn-save" type="submit" value="добавить"/>
                </div>
        </form>
</div>
