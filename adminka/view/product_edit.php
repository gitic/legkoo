<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

$pageDir = 'products';
if(!isset($_GET['id'])){
    die("Статья не найдена <br> <a href='?view=$pageDir'>назад</a>");
}
else{  
    $rowId = $_GET['id'];
    $tmpImgDir = "../content/tmp/$pageDir/$rowId/";
    $dir = "content/$pageDir/$rowId/";
}

//Обработка формы
if(isset($_POST['submit'])){
    if(isset($_POST['visible'])){$visible = 1;}else{$visible = 0;}
    $date_edit = date('Y-m-d H:i:s');
    $seo_description = clear($conn, htmlentities($_POST['seo_description'],ENT_QUOTES));
    $seo_keywords = clear($conn, htmlentities($_POST['seo_keywords'],ENT_QUOTES));
    $title = clear($conn, htmlentities($_POST['title'],ENT_QUOTES));
    $translit = clear($conn, htmlentities($_POST['translit'],ENT_QUOTES));
    if($_POST['sub_category'] != '0'){
        $category = preg_replace('/[^0-9]+/ui', '', $_POST['sub_category']);
    }
    else{
        $category = preg_replace('/[^0-9]+/ui', '', $_POST['category']);
    }
    $articul = preg_replace('/[^0-9]+/ui', '', $_POST['articul']);
    $quantity = preg_replace('/[^0-9]+/ui', '', $_POST['quantity']);
    $video = clear($conn, htmlentities($_POST['video'],ENT_QUOTES));
    $description = $_POST['description'];
    $instruction = clear($conn, htmlentities($_POST['instruction'],ENT_QUOTES));
    $age_from = preg_replace('/[^0-9 .]+/ui', '', $_POST['age_from']);
    $age_to = preg_replace('/[^0-9 .]+/ui', '', $_POST['age_to']);
    $price = preg_replace('/[^0-9 .]+/ui', '', $_POST['price']);
    $old_price = preg_replace('/[^0-9 .]+/ui', '', $_POST['old_price']);
    if(isset($_POST['male'])){$male = 1;}else{$male = 0;}
    if(isset($_POST['female'])){$female = 1;}else{$female = 0;}
    $elements = preg_replace('/[^0-9]+/ui', '', $_POST['elements']);
    $size = clear($conn, htmlentities($_POST['size'],ENT_QUOTES));
    $labels = clear($conn, htmlentities($_POST['labels'],ENT_QUOTES));
    $galleryUpload = clear($conn, htmlentities($_POST['galleryUpload'],ENT_QUOTES));
    $galleryDelete = clear($conn, htmlentities($_POST['galleryDelete'],ENT_QUOTES));
    $galleryRow = clear($conn, htmlentities($_POST['galleryRow'],ENT_QUOTES));
    
    //Сохраняем внешние изображения
    $html = $description;
    preg_match_all("/<[Ii][Mm][Gg][\s]{1}[^>]*[Ss][Rr][Cc][^=]*=[ '\"\s]*([^ \"'>\s#]+)[^>]*>/", $html, $matches);
    $urls = $matches[1];
    if(count($urls)>0){
        if(!is_dir('../'.$dir)){
            mkdir('../'.$dir, 0777);
        }
        if(!is_dir('../'.$dir.'image')){
            mkdir('../'.$dir.'image', 0777);
        }

        for ($i = 0; $i < count($urls); $i++){
            if(strpos($urls[$i], PATH)=== false){
                $iName = substr(strrchr($urls[$i],'/'), 1);
                $file_ext = strrchr($iName, '.');
                $iName = $i.$file_ext;
                if(!is_file('../'.$dir.'image/'.$iName)){
                    $image = new SimpleImage();
                    $succes = $image->load($urls[$i]);
                    if($succes){
                        if($image->getWidth() > 1000){
                            $image->resizeToWidth(1000);
                        }
                        else if($image->getHeight() > 1000){
                            $image->resizeToHeight(1000);
                        }
                        $image->save('../'.$dir.'image/'.$iName);
                    }
                    $replace = PATH.'/'.$dir.'image/'.$iName;
                    $description = str_replace($urls[$i], $replace, $description);
                }
            }
        }
    }
    //Сохраняем внешние изображения//
    $values = array(
        'date_edit'=>$date_edit,
        'seo_description'=>$seo_description,
        'seo_keywords'=>$seo_keywords,
        'visible'=>$visible,
        'title'=>$title,
        'translit'=>$translit,
        'category'=>$category,
        'articul'=>$articul,
        'quantity'=>$quantity,
        'video'=>$video,
        'description'=>$description,
        'instruction'=>$instruction,
        'age_from'=>$age_from,
        'age_to'=>$age_to,
        'price'=>$price,
        'old_price'=>$old_price,
        'male'=>$male,
        'female'=>$female,
        'elements'=>$elements,
        'size'=>$size,
        'labels'=>$labels,
        'gallery'=>$galleryRow
    );
//    print_arr($values);
    $success = Product::update($values, array('id'=>$rowId), $conn);
    if(!$success){
        die("Ошибка при обновлении <br> <a href='?view={$pageDir}'>назад</a>");
    }
    else{
        //Обновление фотографий
        if(is_dir($tmpImgDir)){
            $dir = "content/$pageDir/$rowId";
            if(!is_dir('../'.$dir)){
                mkdir('../'.$dir, 0777);
            }
            $img = $tmpImgDir.'f1.jpg';
            if(file_exists($img)){
                $image = new SimpleImage();
                $succes = $image->load($img);
                $image->save('../'.$dir.'/photo.jpg');
                $pictures = array('photo'=>$dir.'/photo.jpg');
                Product::update($pictures, array('id'=>$rowId), $conn);
            }
            if($galleryUpload != ''){
                $dir = "content/$pageDir/$rowId/gallery";
                if(!is_dir('../'.$dir)){
                    mkdir('../'.$dir, 0777);
                }
                $iArr = explode(',', $galleryUpload);
                $size = count($iArr)-1;
                for($i=0;$i<$size;$i++){
                    $iName = substr($iArr[$i], strrpos($iArr[$i], '/')+1);
                    $image = new SimpleImage();
                    $image->load('../'.$iArr[$i]);
                    $image->save('../'.$dir.'/'.$iName);
                }
            }
            
            delDir($tmpImgDir);
        }
        if($galleryDelete != ''){
            $dir = "content/$pageDir/$rowId/gallery";
            if(!is_dir('../'.$dir)){
                mkdir('../'.$dir, 0777);
            }
            $iArr = explode(',', $galleryDelete);
            $size = count($iArr)-1;
            for($i=0;$i<$size;$i++){
                unlink('../'.$dir.'/'.$iArr[$i]);
            }
        }
        echo '<script type="text/javascript">window.location = "?view='.$pageDir.'"</script>';
        die();
    }    
}
else{
    if(is_dir($tmpImgDir)){
        delDir($tmpImgDir);
    }
}
if(isset($_GET['cancel'])){
    if(is_dir($tmpImgDir)){
        delDir($tmpImgDir);
    }
    echo '<script type="text/javascript">window.location = "?view='.$pageDir.'"</script>';
    die();
}
$product = new Product();
$product->getFomDb(array('id'=>$rowId), $conn);

$_SESSION['KCFINDER'] = array(
    'disabled' => false,
    'uploadURL' => "../../content/$pageDir/$product->id",
    'uploadDir' => ""
);
?>
<script src="<?=VIEW?>js/productsJs.js"></script>
<script src="../lib/jquery-ui/jquery-ui.min.js"></script>
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
         "advlist autolink link image lists charmap preview hr anchor pagebreak",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor",
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
        file_browser_callback: function(field, url, type, win) {
            tinyMCE.activeEditor.windowManager.open({
                file: '../lib/kcfinder/browse.php?opener=tinymce4&field=' + field + '&type=' + type,
                title: 'KCFinder',
                width: 700,
                height: 500,
                inline: true,
                close_previous: false
            }, {
                window: win,
                input: field
            });
            return false;
        }
    });
</script>

<h1>
        Редактирование товара
</h1>
<div id="content">
        <form id='edit_form' name="edit_form" action="" method="post" enctype="multipart/form-data">
            <input type="text" hidden name="rowId" class="rowId" value="<?=$product->id?>"/>
            <div class="block">
                <label>SEO description</label>
                <input class="inp" id="seo_description" name="seo_description" style="width:494px" value="<?=$product->seo_description?>" placeholder="" />
            </div>
            <div class="block">
                <label>SEO keywords</label>
                <input class="inp" id="seo_keywords" name="seo_keywords" style="width:494px" value="<?=$product->seo_keywords?>" placeholder="" />
            </div>
            <div class="block">
                <label>Фото</label>
                <div class='uploader f1'>
                        <?php 
                            $link = '';
                            if($product->photo != ''){$link='../'.$product->photo;}
                        ?>
                        <img class='previewImg f1' src='<?=$link?>' width='200' height='200' border='0'>
                        
                        <div class="block">
                            <input class='fileUpload f1' type='file' name='photos' />
                            <input class='inp loadUrlInp f1' style="width: 300px;" name="pic1" value="" type="text" placeholder="Ссылка из интернета">
                            <button type='button' class='loadUrlBtn f1'>Загрузить</button>
                        </div>
                        <div style='display: none' class='loadstatus f1'><img src='view/images/loader.gif' alt='Uploading....'/></div>
                </div>
            </div>
            <div class="block">
                <label for="visible">Видимость</label>
                    <?php
                        if($product->visible == 1){
                            echo '<input id="visible" name="visible" checked="checked" type="checkbox" />';
                        }
                        else{
                            echo '<input id="visible" name="visible" type="checkbox" />';
                        }
                    ?>

            </div>
            
            <div class="block">
                <label>Артикул</label>
                <?php
                    if($product->articul == 0){
                        $product->articul = $product->id;
                    }
                ?>
                <input class="inp" id="articul" name="articul" style="width:494px" value="<?=$product->articul?>" placeholder="Артикул товара" required />
            </div>
            
            <div class="block">
                <label>Название</label>
                <input class="inp" id="title" name="title" style="width:494px" value="<?=$product->title?>" placeholder="Название товара" required />
            </div>
            
            <div class="block">
                <label>Транслит</label>
                <input class="inp" id="translit" name="translit" style="width:494px" value="<?=$product->translit?>" placeholder="Название товара" required />
            </div>
            
            <?php
                $result = $conn->query("SELECT id_index FROM categories WHERE id='$product->category'");
                if($result && $conn->affected_rows >0){
                    $record = $result->fetch_object();
                    if($record->id_index == 0){
                        $category = $product->category;
                        $sub_category = 0;
                        $attr = "display:none";
                    }
                    else{
                        $category = $record->id_index;
                        $sub_category = $product->category;
                        $attr = "display:inline-block";
                    }
                }
                else{
                    $attr = "display:none";
                }
            ?>
            <div class="block">
                    <label>Категория товара</label>
                    <select class="inp category" name="category" style="width:200px;">
                        <option value='0'>---</option>
                        <?php
                            $result = $conn->query("SELECT id,title FROM categories WHERE id_index='0' ORDER BY title ASC");
                            while (list($id, $title) = $result->fetch_array()){
                                echo " <option value='{$id}'>{$title}</option>";
                            }
                        ?>
                    </select>
                    <i style="<?=$attr?>" id='next_arrow' class="fa fa-arrow-right"></i>
                    <select class="inp sub_category" name="sub_category" style="width:200px;<?=$attr?>">
                        <option value='0'>---</option>
                        <?php
                            $result = $conn->query("SELECT id,title FROM categories WHERE id_index='$category'");
                            while (list($id, $title) = $result->fetch_array()){
                                echo " <option value='{$id}'>{$title}</option>";
                            }
                        ?>
                    </select>
                    <?php if(isset($category) && isset($sub_category)):?>
                        <script>
                            $(function() {
                                $(".inp.category").val('<?=$category?>');
                                $(".inp.sub_category").val('<?=$sub_category?>');
                            });
                        </script>
                    <?php endif;?>
            </div>
            
            <div class="block">
                <label>Количество товара</label>
                <input class="inp" id="quantity" name="quantity" style="width:494px" value="<?=$product->quantity?>" placeholder="Количество товара на складе" required />
            </div>
            
            <div class="block">
                    <label>Дата добавления</label>
                    <input class="inp" id="date_add" name="date_add" style="width:494px" value="<?=$product->date_add?>" disabled="disabled"/>
            </div>

            <div class="block">
                    <label>Дата изменения</label>
                    <input class="inp" id="date_edit" name="date_edit" style="width:494px" value="<?=$product->date_edit?>" disabled="disabled"/>
            </div>
            
            <div class="block">
                    <label class="left">Видео</label>
                    <textarea placeholder="Ссылка на видео" class="inp" name="video" style="width:494px;" rows="8"><?=$product->video?></textarea> 
            </div>
            
            <div class="block">
                    <label class="left">Описание товара</label>
                    <textarea class="inp editor" name="description" style="width:494px;" rows="8"><?=$product->description?></textarea> 
                <div class="clear"></div>
            </div>
            
            <div class="block">
                    <label class="left">Инструкция</label>
                    <input class="inp" id="instruction" name="instruction" style="width:494px" value="<?=$product->instruction?>" placeholder="Ссылка"/>
            </div>
            
            <div class="block">
                    <label class="left">Возраст ОТ:</label>
                    <input class="inp" id="age_from" name="age_from" style="width:494px" value="<?=$product->age_from?>"/>
            </div>
            
            <div class="block">
                    <label class="left">Возраст ДО:</label>
                    <input class="inp" id="age_to" name="age_to" style="width:494px" value="<?=$product->age_to?>"/>
            </div>
            
            <div class="block">
                    <label class="left">Цена(грн)</label>
                    <input class="inp" id="price" name="price" style="width:494px" value="<?=$product->price?>"/>
            </div>
            
            <div class="block">
                    <label class="left">Старая цена</label>
                    <input class="inp" id="old_price" name="old_price" style="width:494px" value="<?=$product->old_price?>"/>
            </div>
            
            <div class="block">
                <label >Предназначение</label>
                    <?php
                        if($product->male == 1){
                            echo '<div style="display: inline-block"><input id="male" name="male" checked="checked" type="checkbox" /><label for="male">Для мальчиков</label></div>';
                        }
                        else{
                            echo '<div style="display: inline-block"><input id="male" name="male" type="checkbox" /><label for="male">Для мальчиков</label></div>';
                        }
                    ?>
                    <?php
                        if($product->female == 1){
                            echo '<div style="display: inline-block"><input id="female" name="female" checked="checked" type="checkbox" /><label for="female">Для девочек</label></div>';
                        }
                        else{
                            echo '<div style="display: inline-block"><input id="female" name="female" type="checkbox" /><label for="female">Для девочек</label></div>';
                        }
                    ?>

            </div>
            
            <div class="block">
                    <label class="left">Деталей(шт)</label>
                    <input class="inp" id="elements" name="elements" style="width:494px" value="<?=$product->elements?>"/>
            </div>
            
            <div class="block">
                    <label class="left">Размер коробки</label>
                    <input class="inp" id="size" name="size" style="width:494px" value="<?=$product->size?>"/>
            </div>
            
            <div class="block">
                <label >Метки</label>
                    <div>
                        <?php
                            $lArr = explode(',', $product->labels);
                            $result = $conn->query("SELECT * FROM labels");
                            while ($label = $result->fetch_object()):
                                $check = '';
                                foreach ($lArr as $x) {
                                    if($x == $label->title.'+'.$label->class){
                                        $check = 'checked="checked"';
                                    }
                                }
                        ?>
                        <div style="display: inline-block"><input value="<?=$label->title?>+<?=$label->class?>" id="label_<?=$label->id?>" class="label" <?=$check?> type="checkbox" /><label for="label_<?=$label->id?>"><?=$label->title?></label></div>
                        <?php endwhile;?>
                            <input id="labels" name="labels" type="text" />
                    </div>

            </div>
            
            <div id="block">
                <label >Галерея фотографий</label>
                <script>
                    $(function() {
                      $( ".sortable" ).sortable();
                      $( ".sortable" ).disableSelection();
                    });
                </script>
                <!--блок загрузки фото-->
                    <div class="uploader gallery">
                        <div class='loadstatus gallery' style='display:none'><img src="view/images/loader.gif" alt="Uploading...."/></div>
                        <div id='imageloadbutton'>
                            <input class='fileUpload gallery' type="file" name="photos" />
                            <input type="text" hidden class="image_name gallery" name="image_name" value="g"/>
                        </div>
                    </div>
                <!--блок загрузки фото-->
                <?php
                    $gArr = explode(',', $product->gallery);
                    $lastIndex = '1';
                    if(count($gArr) > 1){
                        $lastIndex = $gArr[0];
                    }
                ?>
                <input hidden type="hidden" name='galleryLastIndex' id='gLastIndex' value="<?=$lastIndex?>"/>
                <input hidden type="hidden" name='galleryDelete' id='galleryDelete' value=""/>
                <input hidden type="hidden" name='galleryUpload' id='galleryUpload' value=""/>
                <input hidden type="hidden" name='galleryRow' id='galleryRow' value="<?=$product->gallery?>"/>
                <ul class="sortable">
                    <?php if(count($gArr) > 1):?>
                        <?php for($i=1;$i<count($gArr);$i++):?>
                            <li class='ui-state-default'><img class='gImg' src='../<?=$gArr[$i]?>?<?=time()?>' width='160' height='120' border='0'><span class='delFoto'><i class='fa fa-times'></i></span></li>
                        <?php endfor;?>
                    <?php endif;?>
                </ul>
                <div class='clear'></div>
            </div>

            <div id="bottom-btn">
                <input name="id" type="hidden" value="">
                <input name="submit" type="submit" value="сохранить" />
                <a href="?view=product_edit&id=<?=$product->id?>&cancel=1" class="cancel">отмена</a>
            </div>
            
        </form>
</div>
