<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

if(isset($_POST['type'])){
    switch ($_POST['type']) {
        case 'sort':
            $id = $_POST['id'];
            $sort = $_POST['sort'];
            $from = $_POST['from'];
            $to = $_POST['to'];
            $fromProduct = $_POST['lastEl'];
            switch ($sort) {
                case 1:
                    $s = 'title ASC';
                    break;
                case 2:
                    $s = 'title DESC';
                    break;
                case 3:
                    $s = 'price ASC';
                    break;
                case 4:
                    $s = 'price DESC';
                    break;
                default:
                    $s = 'id DESC';
                    break;
            }
            $sql = "SELECT t1.*,t2.title AS category FROM products AS t1 LEFT JOIN categories AS t2 ON t1.category=t2.id "
                    . "WHERE t1.visible='1' AND t1.category='$id' AND t1.price >= $from AND t1.price <=$to ORDER BY $s LIMIT $fromProduct,9";
            $result = $conn->query("SELECT COUNT(*) FROM products WHERE visible='1' AND category='$id' AND price >= $from AND price <=$to ORDER BY $s LIMIT $fromProduct,9");
            $total_rows = $result->fetch_array()[0];
            search($sql,$conn,$fromProduct,$total_rows);
            break;
//        case 'age':
//            $id = $_POST['id'];
//            $from = $_POST['from'];
//            $to = $_POST['to'];
//            $sql = "SELECT t1.*,t2.title AS category FROM products AS t1 LEFT JOIN categories AS t2 ON t1.category=t2.id "
//                    . "WHERE t1.visible='1' AND t1.category='$id' AND t1.age_from >= $from AND t1.age_to <=$to ORDER BY id DESC";
//            search($sql,$conn);
//            break;
                case 'showMore':
                    
                    break;
    }
}
function search($sql,$conn,$fromProduct,$total_rows){
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        while ($record = $result->fetch_object()){
            $product = new Product();
            $product = $record;
            printProductCart($product);
        }
        if($fromProduct < $total_rows && $total_rows > 9){
            echo '<span style="cursor: pointer" class="showMore">Показать еще</span>';
        }
    }
    else{
        echo 'empty';
    }
}