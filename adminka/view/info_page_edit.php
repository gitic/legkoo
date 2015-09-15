<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

$pageDir = 'info_pages';
if(!isset($_GET['id'])){
    die("Страница не найдена <br> <a href='?view=$pageDir'>назад</a>");
}
else{
   
    $rowId = $_GET['id'];
    $tmpImgDir = "../content/tmp/$pageDir/$rowId/";
}

//Обработка формы
if(isset($_POST['submit'])){
    if(isset($_POST['visible'])){$visible = 1;}else{$visible = 0;}
    $title = $_POST['title'];
    $text = clear($conn, $_POST['text']);
    $values = array(
        'title'=>$title,
        'text'=>$text
    );
    $success = InfoPage::update($values, array('id'=>$rowId), $conn);
    if(!$success){
        die("Ошибка при обновлении <br> <a href='?view={$pageDir}'>назад</a>");
    }
    else{
        echo '<script type="text/javascript">window.location = "?view='.$pageDir.'"</script>';
    }    
}
$infoPage = new InfoPage();
$infoPage->getFomDb(array('id'=>$rowId), $conn);

$_SESSION['KCFINDER'] = array(
    'disabled' => false,
    'uploadURL' => "../../content/$pageDir/$infoPage->id",
    'uploadDir' => ""
);
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
         "advlist autolink link image lists charmap preview hr anchor pagebreak",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor",
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview fullpage | forecolor backcolor emoticons",
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
        Редактирование страницы
</h1>
<div id="content">
        <form name="edit_form" action="" method="post" enctype="multipart/form-data">
            <div class="block">
                <label>Название страницы</label>
                <input class="inp" id="title" name="title" style="width:494px" value="<?=$infoPage->title?>" placeholder="Название ингредиента" required />
            </div>

            <div class="block">
                        <label class="left">Текст</label>
                        <textarea class="inp editor" name="text" style="width:494px" rows="8"><?=$infoPage->text?></textarea> 
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
