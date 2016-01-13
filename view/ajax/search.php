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
    $row['query']=$term;
    $row['id'] = 'fullSearch';
    $row_set[] = $row;
    echo json_encode($row_set,JSON_UNESCAPED_UNICODE);//format the array into json data
    die();
}
if(isset($_POST['searchData'])){
    $data = json_decode($_POST['searchData']);
    $s = $data->serchStr;
    $pF = $data->priceFrom;
    $pT = $data->priceTo;
    $aF = $data->ageFrom;
    $aT = $data->ageTo;
    $eF = $data->elsFrom;
    $eT = $data->elsTo;
    $cats = $data->categories;
    
    $s = preg_replace('/[\s]{2,}/', ' ', $s);
    $words = explode(' ',$s);

    if($cats == ""){
        die();
    }
    $q="(t1.title LIKE '%$words[0]%'";
    if(count($words)>1){
        for($i=1;$i<count($words);$i++){$q.="OR t1.title LIKE '%$words[$i]%'";}$q.=')';
    }
    else {$q.=')';}

    $q2="(t1.articul LIKE '%$words[0]%'";
    if(count($words)>1){
        for($i=1;$i<count($words);$i++){$q2.="OR t1.articul LIKE '%$words[$i]%'";}$q2.=')';
    }
    else {$q2.=')';}
    $sql = "SELECT t1.*,t2.title AS catName,t2.id AS catId FROM products AS t1 LEFT JOIN categories AS t2 ON t1.category=t2.id WHERE ($q OR $q2) AND t1.visible='1' "
            . "AND t1.price >= $pF AND t1.price <=$pT "
            . "AND t1.age_from >= $aF AND t1.age_to <=$aT "
            . "AND t1.elements >= $eF AND t1.elements <=$eT "
        . "UNION SELECT t1.*,t2.title AS catName,t2.id AS catId FROM products AS t1 LEFT JOIN categories AS t2 ON t1.category=t2.id WHERE t1.category IN ($cats) AND t1.visible='1' "
            . "AND t1.price >= $pF AND t1.price <=$pT "
            . "AND t1.age_from >= $aF AND t1.age_to <=$aT "
            . "AND t1.elements >= $eF AND t1.elements <=$eT "
        . "ORDER BY category ASC,id DESC";
    $result = $conn->query($sql);
    while($record = $result->fetch_object()){
        $product = new Product();
        $product = $record;
        printProductCart($product);
    }
}

