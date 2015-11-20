<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

$pageDir = 'clients';

if(isset($_SERVER["HTTP_REFERER"])){
    $referer_url = $_SERVER["HTTP_REFERER"];
}
else{
    $referer_url = $pageDir;
}
if(!isset($_GET['email'])){
    die("Клиент не найден <br> <a href='".$referer_url."'>назад</a>");
}
else{  
    $email = $_GET['email'];
}

//Обработка формы
if(isset($_POST['submit'])){
    $refererPage = $_POST['refererPage'];
    $name = clear($conn, htmlentities($_POST['name'],ENT_QUOTES));
    $phone = clear($conn, htmlentities($_POST['phone'],ENT_QUOTES));
    $info = clear($conn, htmlentities($_POST['info'],ENT_QUOTES));
    $notes = clear($conn, htmlentities($_POST['notes'],ENT_QUOTES));
    
    $values = array(
        'name'=>$name,
        'phone'=>  json_encode(explode(",", $phone),JSON_UNESCAPED_UNICODE),
        'info'=>$info,
        'notes'=>$notes
    );
//    print_arr($values);
    $success = Client::update($values, array('email'=>$email), $conn);
    if(!$success){
        die("Ошибка при обновлении <br> <a href='?view={$refererPage}'>назад</a>");
    }
    else{
        echo '<script type="text/javascript">window.location = "'.$refererPage.'"</script>';
        die();
    }    
}
$client = new Client();
$success = $client->getFomDb(array('email'=>$email), $conn);
if(!$success){
    die("Клиент не найден <br> <a href='".$referer_url."'>назад</a>");
}
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
            <input type="hidden" name='refererPage' value="<?=$referer_url?>">
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
            <div class="block table">
                <table>
                    <tbody>
                        <tr>
                            <td>Номер</td>
                            <td>Дата</td>
                            <td>Статус заказа</td>
                            <td>Сумма заказа</td>
                            <td></td>
                        </tr>
                        <?php
                            $orderIdArr = explode(",", $client->order_ids);
                            for ($i=0;$i<count($orderIdArr);$i++):
                            $order = new Order();
                            $order->getFomDb(array('id'=>$orderIdArr[$i]), $conn);
                        ?>
                            <tr class="product <?=$order->id?>">
                            <td><input hidden class="pId <?=$order->id?>" value="<?=$order->id?>"/><span><?=$order->id?></span></td>
                            <td valign="top"><span><?=$order->date_add?></span></td>
                            <?php
                                $status = new State();
                                $status->getFomDb(array('id'=>$order->status), $conn);
                            ?>
                            <td><?=$status->title?></td>
                            <td><?=$order->total?></td>
                            <td><a href="?view=order_edit&id=<?=$orderIdArr[$i]?>">просмотр</a></td>
                        </tr>
                        <?php endfor;?>
                    </tbody>
                </table>
            </div>
            <div id="bottom-btn">
                <input name="id" type="hidden" value="">
                <input name="submit" type="submit" value="сохранить" />
                <a href="<?=$referer_url?>" class="cancel">назад</a>
            </div>
            
        </form>
</div>
