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

$order = new Order();
$order->getFomDb(array('id'=>$rowId), $conn);

?>
<script src="<?=VIEW?>js/ordersJs.js"></script>
<h1>
        Редактирование заказа
</h1>
<div id="content">
        <form id="edit_form" name="edit_form" action="" method="post" enctype="multipart/form-data">
            <input type="text" hidden name="rowId" class="rowId" value="<?=$order->id?>"/>
           
            <div class="block">
                <label>Статус заказа</label>
                <select id='state' class="inp state" name="state">
                <?php
                    $result = $conn->query("SELECT * FROM states");
                    while ($state = $result->fetch_object()):
                ?>
                    <option style='background-color: #<?=$state->colour?>' value="<?=$state->id?>"><?=$state->title?></option>
                <?php endwhile;?>
                </select>
                <span class="notifyState" style="color:red;display:none">Статус заказа изменен</span>
                <script>
                    $(function() {
                        $(".inp.state").val('<?=$order->status?>');
                    });
                </script>
            </div>
            
            <div class="block">
                <label>ТТН (ЕН):</label>
                <input class="inp ttn" id="ttn" name="ttn" style="width:150px" value="<?=$order->ttn?>" disabled="disabled"/>
                <?php $vis = "display:none;"; if($order->ttn != ''){$vis = 'display:inline;';}?>
                <span style="cursor:pointer;padding-right:10px;<?=$vis?>" id="checkState">Проверить статус</span>
                <img id='ttn_loader' style="display:none" width='25px' src='../view/images/loader.GIF'>
                <span class="notifyTtn" style="color:red;display:none"></span>
            </div>
            
            <div class="block">
                <label>Дата</label>
                <input class="inp date_add" id="date_add" style="width:494px" value="<?=$order->date_add?>" disabled="disabled"/>
            </div>
            
            <div class="block">
                <label>IP адрес</label>
                <span><a href="http://whatismyipaddress.com/ip/<?=$order->client_ip?>" target="_blank"><?=$order->client_ip?></a></span>
            </div>
            
            <div class="block">
                <label>ФИО</label>
                <input class="inp fio" id="fio" name="fio" style="width:494px" value="<?=$order->fio?>" placeholder="ФИО" required disabled="disabled"/>
            </div>
            
            <div class="block">
                <label>E-Mail</label>
                <input class="inp" id="email" name="email" style="width:494px" value="<?=$order->email?>" placeholder="E-mail" disabled="disabled"/>
            </div>
            
            <div class="block">
                <label>Телефон</label>
                <input class="inp" id="phone" name="phone" style="width:494px" value="<?=$order->phone?>" placeholder="Телефон" disabled="disabled"/>
            </div>
            
            <div class="block">
                    <label class="left">Комментарий клиента</label>
                    <textarea disabled="disabled" class="inp comment" style="width:494px;border:1px solid #E5E5E5 !important;"><?=$order->comment?></textarea> 
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
            ?>
            <script>
                $.cookie('products', '<?=$order->products?>', { expires: 90 });
            </script>
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
                            <td><input hidden class="pId <?=$product->id?>" value="<?=$product->id?>"/><input hidden class="pCat <?=$product->category?>" value="<?=$product->category?>"/><span><?=$product->articul?></span></td>
                            <td valign="top"><img style='float: left' width="70" src="../<?=$product->img?>"><span><?=$product->title?></span></td>
                            <td><input disabled="disabled" class="inp count <?=$product->id?>" value="<?=$product->count?>"/></td>
                            <td><input disabled="disabled" class="inp price <?=$product->id?>" value="<?=$product->price?>"/></td>
                            <td><i style="display:none;cursor:pointer" class="fa fa-times del"></i></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                <input disabled="disabled" style="width:400px;display:none" type="text" value="" placeholder="Артикул или название товара" class="inp productName"/>
                <input hidden type='hidden' id='products' name='products' value=''/>
                <div class="clear"></div>
            </div>
            
            <div class="block">
                <label>Сумма</label>
                <input  disabled="disabled" readonly class="inp sum" id="orderSum" name="sum" style="width:50px" value="<?=$order->sum?>"/>грн
                <div class="clear"></div>
            </div>
            <div class="block">
                <label>Скидка</label>
                <input disabled="disabled" class="inp" id="orderDiscount" name="discount" style="width:50px" value="<?=$order->discount?>"/>
                <div class="clear"></div>
            </div>
            <div class="block">
                <label>Доставка</label>
                <input disabled="disabled" class="inp" id="orderDelivery" name="delivery" style="width:50px" value="<?=$order->delivery?>"/>
                <div class="clear"></div>
            </div>
            <div class="block">
                <label style="font-weight: bold">Всего</label>
                <input disabled="disabled" class="inp" id="orderTotal" name="total" style="width:50px" value="<?=($order->sum)-($order->discount)+($order->delivery)?>"/>грн
                <div class="clear"></div>
            </div>
            
            <div class="block">
                <label class="left">Заметки</label>
                <textarea disabled="disabled" class="inp" name="notes" style="width:494px;"><?=$order->notes?></textarea> 
                <div class="clear"></div>
            </div>
            
            <div class="block">
                <span class="notify" style="float:right;color:red;display:none">Обновлено</span>
                <img class="loaderGif" style="float:right;display:none" src="<?=VIEW?>images/loader.GIF">
                <div class="clear"></div>
            </div>
            <div id="bottom-btn">
                <input style="display:none;" class='save' name="submit" type="submit" value="сохранить" />
                <input class='editOrder' name="submit" type="submit" value="Редактировать" />
                <a href="?view=<?=$pageDir?>" class="cancel back">назад</a>
                <a style="display:none;" href="<?=$_SERVER['REQUEST_URI']?>" class="cancel reload">отмена</a>
            </div>
            
        </form>
</div>
