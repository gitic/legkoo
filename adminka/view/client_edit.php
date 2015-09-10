<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

$pageDir = 'clients';
if(!isset($_GET['email'])){
    die("Клиент не найден <br> <a href='?view=$pageDir'>назад</a>");
}
else{  
    $email = $_GET['email'];
}

//Обработка формы
if(isset($_POST['submit'])){
    $name = clear($conn, htmlentities($_POST['name'],ENT_QUOTES));
    $phone = clear($conn, htmlentities($_POST['phone'],ENT_QUOTES));
//    $category = clear($conn, htmlentities($_POST['category'],ENT_QUOTES));
    
    $values = array(
        'name'=>$name,
        'phone'=>$phone
    );
//    print_arr($values);
    $success = Client::update($values, array('email'=>$email), $conn);
    if(!$success){
        die("Ошибка при обновлении <br> <a href='?view={$pageDir}'>назад</a>");
    }
    else{
        echo '<script type="text/javascript">window.location = "?view='.$pageDir.'"</script>';
        die();
    }    
}
$client = new Client();
$client->getFomDb(array('email'=>$email), $conn);
?>
<script src="../lib/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
    tinymce.init({
        selector: "textarea.editor",
        relative_urls : false,
        remove_script_host : false,
        convert_urls : true,
        style_formats: [
            {title: 'Margin', selector: 'img', styles: {'margin': '0 10px 0 10px'}},
            {title: 'Margin left', selector: 'img', styles: {'margin-left': '10px'}},
            {title: 'Margin right', selector: 'img', styles: {'margin-right': '10px'}}
        ],
        plugins: [
         "advlist autolink link lists charmap preview hr anchor pagebreak",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor",
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link  | print preview media fullpage | forecolor backcolor emoticons",
    });
</script>

<h1>
        Клиенты / Редактирование
</h1>
<div id="content">
        <form id='edit_form' name="edit_form" action="" method="post" enctype="multipart/form-data">
            <input type="text" hidden name="rowId" class="rowId" value="<?=$client->id?>"/>

            <div class="block">
                <label>E-mail</label>
                <span><?=$client->email?></span>
            </div>
            
            <div class="block">
                <label>Имя</label>
                <input class="inp" id="name" name="name" style="width:494px" value="<?=$client->name?>" placeholder="Имя клиента" required />
            </div>
            
            <div class="block">
                <label>Телефон</label>
                <?php
                    $phArr = json_decode($client->phone);
                    $phones = '';
                    foreach ($phArr as $value) {
                        $phones .= ','.$value;
                    }
                    $phones = substr($phones, 1);
                ?>
                <input class="inp" id="phone" name="phone" style="width:494px" value="<?=$phones?>" placeholder="Имя клиента" required />
            </div>
          
            
            <div class="block">
                    <label class="left">Информация</label>
                    <textarea class="inp" name="info" style="width:494px" rows="8"><?=$client->info?></textarea> 
            </div>
            
            <div class="block">
                    <label class="left">Примечание</label>
                    <textarea class="inp" name="notes" style="width:494px;" rows="8"><?=$client->notes?></textarea> 
                <div class="clear"></div>
            </div>
            
            <div class="block">
                    <label class="left">Интересы</label>
                    <?php 
                    $catArr = json_decode($client->categories);
                    $categories = '';
                    foreach ($catArr as $value) {
                        $categories.= ','.$value;
                    }
                    $categories = substr($categories, 1);
                    $result = $conn->query("SELECT * FROM categories WHERE id IN ($categories)");
                    $str = '';
                    while ($category = $result->fetch_object()){
                        $str .= ','.$category->title;
                    }
                    $str = substr($str, 1);
                    echo $str;
                    ?>
                <div class="clear"></div>
            </div>
            <br>
            <?php
                $order = new Order();
                $order->getFomDb(array('id'=>8), $conn);
            ?>
            <div class="block table">
                <table>
                    <tbody>
                        <tr>
                            <td>Номер</td>
                            <td>Дата</td>
                            <td>Статус</td>
                            <td>Стоимость</td>
                            <td></td>
                        </tr>
                        <tr class="product <?=$order->id?>">
                            <td><input hidden class="pId <?=$order->id?>" value="<?=$order->id?>"/><span><?=$order->id?></span></td>
                            <td valign="top"><span><?=$order->date_add?></span></td>
                            <td><?=$order->status?></td>
                            <td><?=$order->total?></td>
                            <td>удалить</td>
                        </tr>
                    </tbody>
                </table>
                <input disabled="disabled" style="width:400px;display:none" type="text" value="" placeholder="Артикул или название товара" class="inp productName"/>
                <input hidden type='hidden' id='products' name='products' value=''/>
                <div class="clear"></div>
            </div>

<!--            <div id="bottom-btn">
                <input name="id" type="hidden" value="">
                <input name="submit" type="submit" value="сохранить" />
                <a href="#" class="cancel">отмена</a>
            </div>-->
            
        </form>
</div>
