<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
$pageDir = 'articles';

//Автозаполнение ингредиентов
if(isset($_GET['term'])){
    $term = trim(strip_tags($_GET['term']));//retrieve the search term that autocomplete sends

    $sql = "SELECT title as value,id,articul,photo FROM products WHERE visible= '1' AND (title LIKE '%".$term."%' OR articul LIKE '%".$term."%')";
    $result = $conn->query($sql);//query the database for entries containing the term

    while ($row = $result->fetch_array())//loop through the retrieved values
    {
        $row['value']=$row['value'];
        $row['id']=(int)$row['id'];
        $row['articul']=(int)$row['articul'];
        $row['photo']=$row['photo'];
        $row_set[] = $row;//build an array
    }
    echo json_encode($row_set,JSON_UNESCAPED_UNICODE);//format the array into json data
    die();
}

if(isset($_POST['type']) && isset($_POST['rowID'])){
    $type = $_POST['type'];
    switch ($type) {
        //Удаление статьи
        case 'del':
            $rowID = $_POST['rowID'];
            //Удаление дирректории сайта
            $dir = '../'.CONTENT.$pageDir.'/'.$rowID;
            if(is_dir($dir)){
                delDir($dir);
            }
            $result = $conn->query("DELETE FROM $pageDir WHERE id='{$rowID}'");
            $numRows = $conn->affected_rows;
            if($numRows == 0){
                die('error');
            }
            //////// Вывод списка статей
            print_articles($conn);
            ////////
            die();
            break;
            
        //Изменение видимости статьи
        case 'visible':
            $rowID = $_POST['rowID'];
            $setVisible = $_POST['visible'];
            $values = array('visible'=>$setVisible);
            
            $selector = array('id'=>$rowID);
            $success = Article::update($values, $selector, $conn);
            if(!$success){
                die('error');
            }
            else{
                echo $setVisible;
            }
            break;
    }
}
else{
    die('Неверный запрос');
}