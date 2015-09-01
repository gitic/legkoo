<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $newState = new State();
    $newState->title = $title;
    $succes = $newState->insert($conn);
    if($succes){
        $id = $conn->insert_id;
        echo '<script type="text/javascript">window.location = "?view=state_edit&id='.$id.'"</script>';
    }
    else{
        echo 'Ошибка при записи в бд';
    }
    
}
?>
<h1>
        Добавить статус заказа
</h1>
<div id="content">
        <form action="" method="post">
                <div class="block">
                        <input class="inp" id="title" name="title" style="width:550px" placeholder="Название статуса" required/>
                        <input name='submit' class="btn-save" type="submit" value="добавить"/>
                </div>
        </form>
</div>
