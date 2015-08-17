<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

function print_products($conn,$search=''){
    //////// Вывод списка товаров
    $q = '';
    $search = trim($search);
    if($search != ''){
        $search = preg_replace('/[\s]{2,}/', ' ', $search);
        $words = explode(' ',$search);
        $q="WHERE (title LIKE '%$words[0]%' ";
        if(count($words)>1){
            for($i=1;$i<count($words);$i++){$q.="AND title LIKE '%$words[$i]%'";}$q.=')';
        }
        else {$q.="OR articul LIKE '$words[0]'";$q.=')';}
    }
    echo $q;
    $result = $conn->query("SELECT id,title,visible,articul,price,quantity FROM products $q ORDER BY id DESC");
    while (list($id,$title,$visible,$articul,$price,$quantity) = $result->fetch_array()){
        if($visible == 1){$visClass = 'fa fa-circle';}
        else{$visClass = 'fa fa-circle-o';}
        echo    "<tr>"
                . "<td class='visible' align='center'><a class='row visible {$id}' title='Видимость'><i class='{$visClass}'></i></a></td>"
                . "<td>{$id}</td>"
                . "<td>{$articul}</td>"
                . "<td><span>{$title}</span></td>"
                . "<td>{$quantity}</td>"
                . "<td>{$price}</td>"
                . "<td><a class='row edit {$id}' href='?view=product_edit&id={$id}' title='Редактировать'><i class='fa fa-pencil'></i></a></td>"
                . "<td><a class='row del {$id}' href='#' title='Удалить'><i class='fa fa-times'></i></a></td>"
                . "</tr>";
    }
    $result->free();
    ////////
}

function print_articles($conn){
    //////// Вывод списка статей
    $result = $conn->query('SELECT id,title,visible,views FROM articles ORDER BY id DESC');
    while (list($id,$title,$visible,$views) = $result->fetch_array()){
        if($visible == 1){$visClass = 'fa fa-circle';}
        else{$visClass = 'fa fa-circle-o';}
        echo    "<tr>"
                . "<td class='visible' align='center'><a class='row visible {$id}' title='Видимость'><i class='{$visClass}'></i></a></td>"
                . "<td>{$id}</td>"
                . "<td><div class='views'><i class='fa fa-eye'></i>{$views}</div><span>{$title}</span></td>"
                . "<td><a class='row edit {$id}' href='?view=article_edit&id={$id}' title='Редактировать'><i class='fa fa-pencil'></i></a></td>"
                . "<td><a class='row del {$id}' href='#' title='Удалить'><i class='fa fa-times'></i></a></td>"
                . "</tr>";
    }
    $result->free();
    ////////
}