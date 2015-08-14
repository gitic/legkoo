<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

$pageDir = 'articles';
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
    if(isset($_POST['top'])){$top = 1;}else{$top = 0;}
    $title = mb_ucfirst($_POST['title']);
    $translit = $_POST['translit'];
    $user_id = $_POST['user_id'];
    $site_id = $_POST['site_id'];
    $category = $_POST['category'];
    $preview = $_POST['preview'];
    $text = $_POST['text'];
    
    //Сохраняем внешние изображения
    $html = $text;
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
                $text = str_replace($urls[$i], $replace, $text);
            }
        }
    }
    //Сохраняем внешние изображения//
    $values = array(
        'visible'=>$visible,
        'top'=>$top,
        'title'=>$title,
        'translit'=>$translit,
        'user_id'=>$user_id,
        'site_id'=>$site_id,
        'preview'=>$preview,
        'category'=>$category,
        'text'=>$text 
    );
//    print_arr($values);
    $success = Article::update($values, array('id'=>$rowId), $conn);
    if(!$success){
        die("Ошибка при обновлении <br> <a href='?view={$pageDir}'>назад</a>");
    }
    else{
        //Обновление иконки
        if(is_dir($tmpImgDir)){
            $dir = "content/$pageDir/$rowId";
            $img = $tmpImgDir.'picture.jpg';
            $image = new SimpleImage();
            $succes = $image->load($img);
            if($succes){
                if(!is_dir('../'.$dir)){
                    mkdir('../'.$dir, 0777);
                }
                $image->save('../'.$dir.'/main_b.jpg');
                $image->cutToSize(300,300);
                $image->save('../'.$dir.'/main_s.jpg');
                $pictures = array('picture_b'=>$dir.'/main_b.jpg','picture_s'=>$dir.'/main_s.jpg');
                Article::updateArticle($pictures, array('id'=>$rowId), $conn);
//                echo 'Иконка изменена<br>';
            }
            else{
//                echo 'Ошибка загрузки<br>';
            }
            delDir($tmpImgDir);
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
$article = new Article();
$article->getFomDb(array('id'=>$rowId), $conn);

$_SESSION['KCFINDER'] = array(
    'disabled' => false,
    'uploadURL' => "../../content/articles/$article->id",
    'uploadDir' => ""
);
?>
<script src="<?=VIEW?>js/articlesJs.js"></script>
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
        Редактирование статьи
</h1>
<div id="content">
        <form name="edit_form" action="" method="post" enctype="multipart/form-data">
            <input type="text" hidden name="rowId" class="rowId" value="<?=$article->id?>"/>
            <div class="block">
                <label>Фото</label>
                <div class='uploader f1'>
                        <img class='previewImg f1' src='' width='150' height='100' border='0'>
                        
                        <div class="block">
                            <input class='fileUpload f1' type='file' name='photos' />
                            <input class='inp loadUrlInp f1' style="width: 300px;" name="pic1" value="" type="text" placeholder="Ссылка из интернета">
                            <button type='button' class='loadUrlBtn f1'>Загрузить</button>
                        </div>
                        <div style='display: none' class='loadstatus f1'><img src='view/images/loader.gif' alt='Uploading....'/></div>
                </div>
            </div>
            <div class="block">
                <label>Фото для акции</label>
                <div class='uploader f1'>
                        <img class='previewImg f2' src='' width='150' height='100' border='0'>
                        
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
                        if($article->visible == 1){
                            echo '<input id="visible" name="visible" checked="checked" type="checkbox" />';
                        }
                        else{
                            echo '<input id="visible" name="visible" type="checkbox" />';
                        }
                    ?>

            </div>
            <div class="block">
                    <label for="top">Топ</label>
                    <?php
                        if($article->top == 1){
                            echo '<input id="top" name="top" checked="checked" type="checkbox"/>';
                        }
                        else{
                            echo '<input id="top" name="top" type="checkbox"/>';
                        }
                    ?>
            </div>
            <div class="block">
                <label>Статья</label>
                <input class="inp" id="title" name="title" style="width:494px" value="<?=$article->title?>" placeholder="Название статьи" required />
            </div>
            
            <div class="block">
                <label>Транслит</label>
                <input class="inp" id="translit" name="translit" style="width:494px" value="<?=$article->translit?>" placeholder="Название статьи" required />
            </div>
            
            <div class="block">
                <label>Категория</label>
                <select class="inp category" name="category" style="width:200px;">
                    <option value='0'>Статья</option>
                    <option value='1'>Новость</option>
                </select>
            </div>
            
            <div class="block">
                    <label class="left">Краткое описание</label>
                    <textarea class="inp" name="preview" style="width:494px" rows="8"><?=$article->preview?></textarea> 
            </div>
            
            <div class="block">
                    <label class="left">Текст статьи</label>
                    <textarea class="inp editor" name="text" style="width:494px" rows="8"><?=$article->text?></textarea> 
                <div class="clear"></div>
            </div>

            <div id="bottom-btn">
                <input name="id" type="hidden" value="">
                <input name="submit" type="submit" value="сохранить" />
                <a href="?view=article_edit&id=<?=$article->id?>&cancel=1" class="cancel">отмена</a>
            </div>
            
        </form>
</div>
