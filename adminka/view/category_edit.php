<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

$pageDir = 'categories';
if(!isset($_GET['id'])){
    die("Категория не найдена <br> <a href='?view=$pageDir'>назад</a>");
}
else{  
    $rowId = $_GET['id'];
    $tmpImgDir = "../content/tmp/$pageDir/$rowId/";
    $dir = "content/$pageDir/$rowId/";
}

//Обработка формы
if(isset($_POST['submit'])){
    if(isset($_POST['visible'])){$visible = 1;}else{$visible = 0;}
    $category = clear($conn, htmlentities($_POST['category'],ENT_QUOTES));
    $cat_hidden = clear($conn, htmlentities($_POST['cat_hidden'],ENT_QUOTES));
    $title = clear($conn, htmlentities($_POST['title'],ENT_QUOTES));
    $translit = clear($conn, htmlentities($_POST['translit'],ENT_QUOTES));
    $position = clear($conn, htmlentities($_POST['position'],ENT_QUOTES));
    if($category != $cat_hidden){
        switch ($category) {
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
    //Сохраняем внешние изображения
    $html = $description;
    preg_match_all("/<[Ii][Mm][Gg][\s]{1}[^>]*[Ss][Rr][Cc][^=]*=[ '\"\s]*([^ \"'>\s#]+)[^>]*>/", $html, $matches);
    $urls = $matches[1];
    if(count($urls)>0){
        if(!is_dir('../'.$dir.'image')){
            mkdir('../'.$dir.'image', 0777,true);
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
        'id_index'=>$category,
        'visible'=>$visible,
        'title'=>$title,
        'translit'=>$translit,
        'description'=>$description,
        'position'=>$position
    );
    $success = Category::update($values, array('id'=>$rowId), $conn);
    if(!$success){
        die("Ошибка при обновлении <br> <a href='?view={$pageDir}'>назад</a>");
    }
    else{
        //Обновление иконки
        if(is_dir($tmpImgDir)){
            $dir = "content/$pageDir/$rowId";
            if(!is_dir('../'.$dir)){
                mkdir('../'.$dir, 0777,true);
            }
            $img1 = $dir.'/logo.jpg';;
            $img2 = $dir.'/photo.jpg';;
            $image = new SimpleImage();
            
            if(file_exists($tmpImgDir.'f1.jpg')){        
                $succes = $image->load($tmpImgDir.'f1.jpg');
                $image->save('../'.$img1);
            }else if(!file_exists('../'.$img1)){$img1 = '';}

            if(file_exists($tmpImgDir.'f2.jpg')){
                $succes = $image->load($tmpImgDir.'f2.jpg');
                $image->save('../'.$img2);
            }else if(!file_exists('../'.$img2)){$img2='';}
            
            $pictures = array('logo'=>$img1,'photo'=>$img2);
            Category::update($pictures, array('id'=>$rowId), $conn);
            delDir($tmpImgDir);
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
        echo '<script type="text/javascript">window.location = "?view='.$pageDir.'"</script>';
//        die("Обновлено <br> <a href='?view=$pageDir'>назад</a>");
    }    
}

$category = new Category();
$category->getFomDb(array('id'=>$rowId), $conn);

$_SESSION['KCFINDER'] = array(
    'disabled' => false,
    'uploadURL' => "../../content/$pageDir/$category->id",
    'uploadDir' => ""
);
?>
<script src="<?=VIEW?>js/categoriesJs.js"></script>
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
        Редактирование категории
</h1>
<div id="content">
        <form name="edit_form" action="" method="post" enctype="multipart/form-data">
            <input type="text" hidden name="rowId" class="rowId" value="<?=$category->id?>"/>
            <div class="block">
                <label>Логотип</label>
                <div class='uploader f1'>
                        <?php 
                            $link = '';
                            if($category->logo != ''){$link='../'.$category->logo;}
                        ?>
                        <img class='previewImg f1' src='<?=$link?>' width='500' height='150' border='0'>
                        
                        <div class="block">
                            <input class='fileUpload f1' type='file' name='photos'/>
                            <input class='inp loadUrlInp f1' style="width: 300px;" name="pic1" value="" type="text" placeholder="Ссылка из интернета">
                            <button type='button' class='loadUrlBtn f1'>Загрузить</button>
                        </div>
                        <div style='display: none' class='loadstatus f1'><img src='view/images/loader.gif' alt='Uploading....'/></div>
                </div>
            </div>
            <div class="block">
                <label>Фото</label>
                <div class='uploader f2'>
                        <?php 
                            $link = '';
                            if($category->photo != ''){$link='../'.$category->photo;}
                        ?>
                        <img class='previewImg f2' src='<?=$link?>' width='150' height='200' border='0'>
                        
                        <div class="block">
                            <input class='fileUpload f2' type='file' name='photos' />
                            <input class='inp loadUrlInp f2' style="width: 300px;" name="pic1" value="" type="text" placeholder="Ссылка из интернета">
                            <button type='button' class='loadUrlBtn f2'>Загрузить</button>
                        </div>
                        <div style='display: none' class='loadstatus f2'><img src='view/images/loader.gif' alt='Uploading....'/></div>
                </div>
            </div>
            <div class="block">
                <label for="visible">Видимость</label>
                    <?php
                        if($category->visible == 1){
                            echo '<input id="visible" name="visible" checked="checked" type="checkbox" />';
                        }
                        else{
                            echo '<input id="visible" name="visible" type="checkbox" />';
                        }
                    ?>

            </div>
            <div class="block">
                <label>Ингредиент</label>
                <input class="inp" id="title" name="title" style="width:494px" value="<?=$category->title?>" placeholder="Название ингредиента" required />
            </div>
            <div class="block">
                <label>Транслит</label>
                <input class="inp" id="translit" name="translit" style="width:494px" value="<?=$category->translit?>" placeholder="Название ингредиента" required />
            </div>
            <?php
                $attr = '';
                $conn->query("SELECT id FROM categories WHERE id_index='{$category->id}'");               
                if($conn->affected_rows > 0){$attr = 'disabled';}
            ?>
            <div class="block">
                <label>Категория</label>
                <input id='cat_hidden' hidden name='cat_hidden' value="<?=$category->id_index?>" />
                <input id='position' hidden name='position' value="<?=$category->position?>" />
                <select class="inp category" name="category" style="width:150px;">
                    <option value='0'>Основная категория</option>
                    <?php
                        $conn->query("SELECT id FROM categories WHERE id_index='{$category->id}'");
                        if($conn->affected_rows == 0){
                            $result = $conn->query("SELECT id,title FROM $pageDir WHERE id_index='0' AND id!='{$category->id}'");
                            while (list($id, $title) = $result->fetch_array()){
                                echo " <option value='{$id}'>{$title}</option>";
                            }
                        }                     
                    ?>
                </select>
                <script>
                    $(function() {
                        $(".inp.category").val('<?=$category->id_index?>');
                    });
                </script>
            </div>
            
            <div class="block">
                    <label class="left">Описание категории</label>
                    <textarea class="inp editor" name="description" style="width:494px;" rows="8"><?=$category->description?></textarea> 
                <div class="clear"></div>
            </div>
        
            <div id="bottom-btn">
                <input name="id" type="hidden" value="">
                <input name="submit" type="submit" value="сохранить" />
                <a href="?view=<?=$pageDir?>" class="cancel">отмена</a>
                <a style='display:none;' href="" title="Удалить" class="del"><i class="fa fa-times"></i></a>
            </div>
            
        </form>
</div>
