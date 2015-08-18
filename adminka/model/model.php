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

//Отображение списка категорий блюд
function showCatDishesRows(array $cat_dishes,$sub=0){
    foreach ($cat_dishes as $row) {
        if($row['visible'] == 1){$visClass = 'fa fa-circle';}
        else{$visClass = 'fa fa-circle-o';}

        if($sub == 0){$id = $row['id'];$id_index = '';$space='';}
        else{$id = '';$id_index = $row['id_index'];$space='&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';}
        $delBtn = '';
        $visibleBtn = '';
        $arrowBtn = '<td></td><td></td>';
        $pos = '';
        if(!isset($row['sub'])){
            $delBtn = "<a class='row del {$row['id']}' href='#' title='Удалить'><i class='fa fa-times'></i></a>";
        }
        if($row['id_index']==0){
            $arrowBtn = "<td style='cursor:pointer;' class='row up {$row['id']}'><i class='fa fa-chevron-up'></i><input hidden type='text' id='pos_{$row['id']}' value='{$row['position']}'/></td>";
            $arrowBtn.= "<td style='cursor:pointer;' class='row down {$row['id']}'><i class='fa fa-chevron-down'></i></td>";
            $pos = $row['position'];
        }
        $visibleBtn = "<a class='row visible {$row['id']}' title='Видимость'><i class='{$visClass}'></i></a>";
        echo    "<tr>"      
                . "<td class='visible' align='center'>{$visibleBtn}</td>"
                . "<td>{$id}</td>"
                . "<td><span>{$space} {$row['title']}</span></td>"
                . "$arrowBtn"
                . "<td><a class='row edit {$row['id']}' href='?view=category_edit&id={$row['id']}' title='Редактировать'><i class='fa fa-pencil'></i></a></td>"
                . "<td>{$delBtn}</td>"
                . "</tr>";
        if(isset($row['sub'])){
            showCatDishesRows($row['sub'],1);
        }
    }
}