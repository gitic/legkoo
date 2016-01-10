<?php

//Автозаполнение поиск
if(isset($_GET['term'])){
    $term = trim(strip_tags($_GET['term']));//retrieve the search term that autocomplete sends

    $sql = "SELECT id,title,translit,articul,photo,price,category FROM products WHERE visible= '1' AND (title LIKE '%".$term."%' OR articul LIKE '%".$term."%') ORDER BY id DESC LIMIT 0,5";
    $result = $conn->query($sql);//query the database for entries containing the term

    while ($product = $result->fetch_array())//loop through the retrieved values
    {
        $row['value']=  html_entity_decode($product['title']);
        $row['translit']=$product['translit'];
        $row['id']=(int)$product['id'];
        $row['articul']=(int)$product['articul'];
        $row['photo']=$product['photo'];
        $row['price']=$product['price'];
        $row['category']=$product['category'];
        $row_set[] = $row;//build an array
    }
    $row['value'] = 'Показать все результаты';
    $row['id'] = 'fullSearch';
    $row_set[] = $row;
    echo json_encode($row_set,JSON_UNESCAPED_UNICODE);//format the array into json data
    die();
}

