<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

$pageDir = 'orders';
if(!isset($_GET['id'])){
    die("Заказ не найден <br> <a href='?view=$pageDir'>назад</a>");
}
else{  
    $rowId = $_GET['id'];
}

//Обработка формы
if(isset($_POST['submit'])){
    if(isset($_POST['visible'])){$visible = 1;}else{$visible = 0;}
    $order = clear($conn, htmlentities($_POST['category'],ENT_QUOTES));
    $cat_hidden = clear($conn, htmlentities($_POST['cat_hidden'],ENT_QUOTES));
    $title = clear($conn, htmlentities($_POST['title'],ENT_QUOTES));
    $translit = clear($conn, htmlentities($_POST['translit'],ENT_QUOTES));
    $position = clear($conn, htmlentities($_POST['position'],ENT_QUOTES));
    if($order != $cat_hidden){
        switch ($order) {
            case '0':
                $result = $conn->query("SELECT COUNT(*) FROM categories WHERE id_index='0'");
                $numRows = $result->fetch_row();
                $numRows = $numRows[0] + 1;
                $position = $numRows;
                break;

            default:
                $position = 0;
                break;
        }
    }
    $description = $_POST['description'];
    $values = array(
        'id_index'=>$order,
        'visible'=>$visible,
        'title'=>$title,
        'translit'=>$translit,
        'description'=>$description,
        'position'=>$position
    );
    $success = Order::update($values, array('id'=>$rowId), $conn);
    if(!$success){
        die("Ошибка при обновлении <br> <a href='?view={$pageDir}'>назад</a>");
    }
    else{
        echo '<script type="text/javascript">window.location = "?view='.$pageDir.'"</script>';
    }    
}

$order = new Order();
$order->getFomDb(array('id'=>$rowId), $conn);

?>
<script src="<?=VIEW?>js/ordersJs.js"></script>
<h1>
        Редактирование заказа
</h1>
<div id="content">
        <form name="edit_form" action="" method="post" enctype="multipart/form-data">
            <input type="text" hidden name="rowId" class="rowId" value="<?=$order->id?>"/>
           
            <div class="block">
                <label>Дата</label>
                <input class="inp" id="date_add" name="date_add" style="width:494px" value="<?=$order->date_add?>" disabled="disabled"/>
            </div>
            
            <div class="block">
                <label>ФИО</label>
                <input class="inp" id="fio" name="fio" style="width:494px" value="<?=$order->fio?>" placeholder="ФИО" required disabled="disabled"/>
            </div>
            
            <div class="block">
                <label>E-Mail</label>
                <input class="inp" id="email" name="email" style="width:494px" value="<?=$order->email?>" placeholder="ФИО" disabled="disabled"/>
            </div>
            
            <div class="block">
                <label>Телефон</label>
                <input class="inp" id="phone" name="phone" style="width:494px" value="<?=$order->phone?>" placeholder="ФИО" disabled="disabled"/>
            </div>
            
            <div class="block">
                    <label class="left">Комментарий клиента</label>
                    <textarea disabled="disabled" class="inp" name="comment" style="width:494px;"><?=$order->comment?></textarea> 
                <div class="clear"></div>
            </div>
            
            <div class="block">
                    <label>Способ доставки</label>
                    <select disabled="disabled" class="inp delivery_type" name="delivery_type" style="min-width: 300px">
                        <option value="0">---</option>
                        <option value="1">На склад "Новой Почты" (за счет получателя).</option>
                        <option value="2">Адресная доставка по Украине(Новая Почта).</option>
                        <option value="3">Самовывоз.</option>
                    </select>
                    <div class="clear"></div>
                    <input style="width:494px;margin-left: 153px" class="inp" id="delivery_adress" name="delivery_adress" value="<?=$order->delivery_adress?>" placeholder="Адрес доставки" disabled="disabled"/>
                    <script>
                        $(function() {
                            $(".inp.delivery_type").val('<?=$order->delivery_type?>');
                        });
                    </script>
                <div class="clear"></div>
            </div>
            
            <div class="block">
                    <label>Способ оплаты</label>
                    <select disabled="disabled" class="inp payment_type" name="payment_type" style="min-width: 300px">
                        <option value="0">---</option>
                        <option value="1">Наличными при получении</option>
                        <option value="2">Кредитная карта</option>
                    </select>
                    <script>
                        $(function() {
                            $(".inp.payment_type").val('<?=$order->payment_type?>');
                        });
                    </script>
                <div class="clear"></div>
            </div>
            
            <?php
                $arr = json_decode($order->products);
//                print_arr($arr);
            ?>
            <div class="block table">
                <table>
                    <tbody>
                        <tr>
                            <td>Артикул</td>
                            <td>Название</td>
                            <td>Количество</td>
                            <td>Цена(грн)</td>
                            <td></td>
                        </tr>
                        <?php
                            foreach ($arr as $product):
                        ?>
                        <tr class="product <?=$product->id?>">
                            <td><input hidden class="pID <?=$product->id?>" value="<?=$product->id?>"/><?=$product->articul?></td>
                            <td valign="top"><img style='float: left' width="70" src="../<?=$product->img?>"> <?=$product->title?></td>
                            <td><input disabled="disabled" class="inp count <?=$product->id?>" value="<?=$product->count?>"/></td>
                            <td><input disabled="disabled" class="inp price <?=$product->id?>" value="<?=$product->price?>"/></td>
                            <td><i style="display:none;cursor:pointer" class="fa fa-times del"></i></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                <div class="clear"></div>
            </div>
            
            <div class="block">
                <label>Сумма</label>
                <input  disabled="disabled" readonly class="inp" id="orderSum" name="productsSum" style="width:50px" value="<?=$order->sum?>"/>грн
                <div class="clear"></div>
            </div>
            <div class="block">
                <label>Скидка</label>
                <input disabled="disabled" class="inp" id="orderDiscount" name="productsSum" style="width:50px" value="0"/>
                <div class="clear"></div>
            </div>
            <div class="block">
                <label>Доставка</label>
                <input disabled="disabled" class="inp" id="orderDelivery" name="productsSum" style="width:50px" value="0"/>
                <div class="clear"></div>
            </div>
            <div class="block">
                <label style="font-weight: bold">Всего</label>
                <input disabled="disabled" class="inp" id="orderTotal" name="productsSum" style="width:50px" value="<?=$order->sum?>"/>грн
                <div class="clear"></div>
            </div>
            
            <div class="block">
                <label class="left">Заметки</label>
                <textarea disabled="disabled" class="inp" name="notes" style="width:494px;"><?=$order->notes?></textarea> 
                <div class="clear"></div>
            </div>
            <div id="bottom-btn">
                <input name="id" type="hidden" value="">
                <input style="display:none;" class='save' name="submit" type="submit" value="сохранить" />
                <input class='editOrder' name="submit" type="submit" value="Редактировать" />
                <a href="?view=<?=$pageDir?>" class="cancel back">назад</a>
                <a style="display:none;" href="<?=$_SERVER['REQUEST_URI']?>" class="cancel reload">отмена</a>
            </div>
            
        </form>
</div>
