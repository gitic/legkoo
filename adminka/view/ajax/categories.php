<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

if(isset($_POST['type']) && isset($_POST['rowID'])){
    $type = $_POST['type'];
    switch ($type) {
        //Удаление категории
        case 'del':
            $rowID = $_POST['rowID'];
            $result = $conn->query("DELETE FROM categories WHERE id='{$rowID}'");
            $numRows = $conn->affected_rows;
            if($numRows == 0){
                die('error');
            }
            
            $result = $conn->query("SELECT id FROM categories WHERE id_index='0' ORDER BY position");
            $numRows = $conn->affected_rows;
            if($numRows != 0){
                $i=0;
                while ($record = $result->fetch_object()){
                    $i++;
                    $conn->query("UPDATE categories SET position='{$i}' WHERE id='{$record->id}'");
                }
            }
//            else{
//                die('error');
//            }
            
            //////// Вывод списка категорий
                $result = $conn->query('SELECT id,id_index,position,title,visible FROM categories ORDER BY id_index,position,title');
                $catArr = array();
                while (list($id,$id_index,$position,$title,$visible) = $result->fetch_array()){

                    if($id_index == 0){
                        $catArr[$id] = array('id'=>$id, 'id_index'=>$id_index, 'position'=>$position, 'title'=>$title,'visible'=>$visible);
                    }
                    else{
                        $catArr[$id_index]['sub'][$id] = array('id'=>$id, 'id_index'=>$id_index, 'position'=>$position, 'title'=>$title,'visible'=>$visible);
                    }
                }
                $result->free();
                showCatDishesRows($catArr);
            ////////
            die();
            break;
            
        //Изменение видимости категории
        case 'visible':
            $rowID = $_POST['rowID'];
            $setVisible = $_POST['visible'];
            
            $query = "UPDATE categories SET visible='{$setVisible}' WHERE id='{$rowID}'";
            $result = $conn->query($query);
            if(!$result){
                die('error');
            }
            else{
                echo $setVisible;
            }
            break;
            
        //Изменение позиции категории
        case 'position':
            $rowID = $_POST['rowID'];
            $direction = $_POST['direction'];
            $position = $_POST['position'];
                
            switch ($direction) {
                case 'up':
                    $newPos = $position-1;
                    
                    $query = "SELECT id FROM categories WHERE position='{$newPos}' AND id_index='0'";
                    $result = $conn->query($query);
                    if($result && $conn->affected_rows > 0){
                        $row1 = $result->fetch_object();$result->free();
                        $query = "UPDATE categories SET position='{$position}' WHERE id='{$row1->id}'";
                        $result = $conn->query($query);
                        if(!$result){
                            die('error');
                        }
                    }
                    else{die('error');}
                    
                    $query = "UPDATE categories SET position='{$newPos}' WHERE id='{$rowID}'";
                    $result = $conn->query($query);
                    if(!$result){
                        die('error');
                    }
                    break;
                
                case 'down':
                    $newPos = $position+1;
                    
                    $query = "SELECT id FROM categories WHERE position='{$newPos}' AND id_index='0'";
                    $result = $conn->query($query);
                    if($result && $conn->affected_rows > 0){
                        $row1 = $result->fetch_object();$result->free();
                        $query = "UPDATE categories SET position='{$position}' WHERE id='{$row1->id}'";
                        $result = $conn->query($query);
                        if(!$result){
                            die('error');
                        }
                    }
                    else{die('error');}
                    
                    $query = "UPDATE categories SET position='{$newPos}' WHERE id='{$rowID}'";
                    $result = $conn->query($query);
                    if(!$result){
                        die('error');
                    }

                    break;
            }
            //////// Вывод списка категорий
                $result = $conn->query('SELECT id,id_index,position,title,visible FROM categories ORDER BY id_index,position,title');
                $catArr = array();
                while (list($id,$id_index,$position,$title,$visible) = $result->fetch_array()){

                    if($id_index == 0){
                        $catArr[$id] = array('id'=>$id, 'id_index'=>$id_index, 'position'=>$position, 'title'=>$title,'visible'=>$visible);
                    }
                    else{
                        $catArr[$id_index]['sub'][$id] = array('id'=>$id, 'id_index'=>$id_index, 'position'=>$position, 'title'=>$title,'visible'=>$visible);
                    }
                }
                $result->free();
                showCatDishesRows($catArr);
            ////////
            break;
    }
}
else{
    die('Неверный запрос');
}

