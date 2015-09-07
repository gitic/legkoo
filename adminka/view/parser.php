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
            //        $item['price'] = floatval($row->find('td', 7)->plaintext); // парсим цену
                    if($item['articul'] != 0){
                        $rows[] = $item; // пишем в массив
                    }
                }
            }
            $products = array();
            $dublicates = array();
            foreach ($rows as $row) {
                if(!array_key_exists($row['articul'], $products)){
                    $products[$row['articul']] = $row['count'];
                }
                else{
                    $dublicates[] = $row['articul'];
                }
            }

            $sql = "SELECT articul FROM products";
            $result = $conn->query($sql);
            $i=0;
            $values = '';
            while ($row = $result->fetch_object()){
                if(array_key_exists($row->articul, $products)){
                    $i++;
                    $articul = $row->articul;
                    $count = $products[$row->articul];
                    $values .= ",($articul,$count)";
            //        echo $i.'. '.$row->articul.' - '.$products[$row->articul].'<br>';
                }
            }
            $values = substr($values, 1);

            $sql = "INSERT INTO products (articul,quantity) VALUES $values ON DUPLICATE KEY UPDATE quantity=VALUES(quantity)";
            $result = $conn->query($sql);
            $rowsUpdated = $conn->affected_rows/2;
            echo 'Затронуто товаров: '.$i.'<br>';
            echo 'Обновлено: '.$rowsUpdated.'<br>';
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
