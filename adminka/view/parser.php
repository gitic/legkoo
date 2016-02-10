<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

function printForm(){
?>
<h1>
    Загрузка файла товаров
</h1>
<div id="content" style='min-width: 800px'>
    <form id='fileForm' action='' method='post' enctype='multipart/form-data' onsubmit="return confirm('Выполнить обновление товаров?');">
        <input type='file' name='uploadfile'>
        <input type='submit' value='Загрузить'>
    </form>
</div>
<?php    
}
require_once '../lib/simple_html_dom.php';

if(isset($_FILES['uploadfile']['name'])){
    if($_FILES['uploadfile']['type'] == 'text/html'){
        $newname = "../content/text.htm";
        if(!move_uploaded_file($_FILES['uploadfile']['tmp_name'], $newname)){
            die('Ошибка загрузки файла');
        }
        else{
            $html = file_get_html('../content/text.htm');

            foreach ($html->find('tr') as $row) { //выбираем все tr сообщений
                if($row->find('td', 3) && $row->find('td', 6)){
                    $item['articul'] = intval($row->find('td', 3)->plaintext); // парсим артикул в html формате
                    $item['count'] = intval($row->find('td', 6)->plaintext); // парсим количество
                    $item['price'] = intval($row->find('td', 7)->plaintext); // парсим цену
                    if($item['articul'] != 0){
                        $rows[] = $item; // пишем в массив
                    }
                }
            }
            $products = array();
            $dublicates = array();
            foreach ($rows as $row) {
                if(!array_key_exists($row['articul'], $products)){
                    $data['count'] = $row['count'];
                    $data['price'] = $row['price'];
                    $products[$row['articul']] = $data;
                }
                else{
                    $dublicates[] = $row['articul'];
                }
            }
            
            //Обновляем существующие товары
            $i=0;
            $values = '';
            foreach ($products as $key => $value) {
                $i++;
                $count = $value['count'];
                $price = $value['price'];
                $values .= ",($key,$count,$price)";
//                echo $i.'. '.$key.' - '.$count.' - '.$price.'<br>';
            }
            $values = substr($values, 1);
            $sql = "INSERT INTO products (articul,quantity,price) VALUES $values ON DUPLICATE KEY UPDATE quantity=VALUES(quantity),price=VALUES(price)";
            $result = $conn->query($sql);
            
            //Обновляем дату
            $date = date('Y-m-d H:i:s');
            $sql = "UPDATE products SET date_add='$date',date_edit='$date' WHERE date_add='0000-00-00 00:00:00'";
            $conn->query($sql);
            
            //Ставим отсутствующие товары в Ноль
            $sql = "SELECT articul FROM products";
            $result = $conn->query($sql);
            $values = '';
            $i--;
            while ($row = $result->fetch_object()){
                if(!array_key_exists($row->articul, $products)){
                    $i++;
                    $articul = $row->articul;
                    $count = 0;
                    $values .= ",($articul,$count)";
//                    echo $i.'. '.$row->articul.' - <br>';
                }
            }
            $values = substr($values, 1);
            $sql = "INSERT INTO products (articul,quantity) VALUES $values ON DUPLICATE KEY UPDATE quantity=VALUES(quantity)";
            $result = $conn->query($sql);
            
            $ress = $conn->query("SELECT MAX(id) FROM products");
            $maxId = $ress->fetch_array()[0] + 1;
            $conn->query("ALTER TABLE products AUTO_INCREMENT=$maxId;");
            
            $rowsUpdated = $conn->affected_rows;
            echo 'Затронуто товаров: '.$i.'<br>';
            echo 'Обновлено <br>';
            $numDubl = count($dublicates);
            if($numDubl > 0){
                echo "Найдены дубликаты артикулов в файле - $numDubl:<br>";
                foreach ($dublicates as $articul) {
                    print_arr($articul);
                }
            }
            echo "<a href='?view=parser'>назад</a>";
            $html->clear(); 
            unset($html);
            delDir($newname);
        }
    }
    else{
        echo "<p style='color:red;'>Неверный формат файла</p><br>";
        printForm();
    }
}
else{printForm();}
?>
