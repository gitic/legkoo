<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $date = date('Y-m-d H:i:s');
    $newProduct = new Product();
    $newProduct->title = $title;
    $newProduct->translit = mb_strtolower(translitIt($title));
    $newProduct->visible = 0;
    $newProduct->date_add = $date;
    $newProduct->date_edit = $date;
    $succes = $newProduct->insert($conn);
    if($succes){
        $id = $conn->insert_id;
        echo '<script type="text/javascript">window.location = "?view=product_edit&id='.$id.'"</script>';
    }
    else{
        echo 'Ошибка при записи в бд';
    }    
}
?>
<h1>
        Добавить товар
</h1>
<div id="content">
        <form action="" method="post">
                <div class="block">
                        <input class="inp" id="title" name="title" style="width:550px" placeholder="Название товара" required/>
                        <input name='submit' class="btn-save" type="submit" value="добавить"/>
                </div>
        </form>
</div>
