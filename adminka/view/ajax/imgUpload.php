<?php

error_reporting(0);

define("MAX_SIZE", "2");

function getExtension($str) {
    $ext = strrchr($str, '.');
    return $ext;
}

$data = array();
$whitelist = array(".jpg", ".jpeg", ".gif", ".png", ".JPG", ".JPEG", ".GIF", ".PNG");

if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
    $rowId = $_POST['rowId'];
    $fileDir = $_POST['dir'];
    $uploaddir = "../content/tmp/{$fileDir}/{$rowId}/";
    if (!is_dir($uploaddir)) {
        mkdir($uploaddir, 0777,true);
    }
    if(isset($_POST['width']) && isset($_POST['height'])){
        $setWidth = $_POST['width'];
        $setHeight = $_POST['height'];
    }
    if(isset($_POST['minWidth']) && isset($_POST['minHeight'])){
        $minWidth = $_POST['minWidth'];
        $minHeight = $_POST['minHeight'];
    }
    
    switch ($_POST['type']) {
        case 'loadUrl':
            $url = $_POST['url'];
            $image_name = 'picture.jpg';
            if (isset($_POST['image_name'])) {
                $image_name = $_POST['image_name'] . '.jpg';
            }

            $newname = $uploaddir . $image_name;
            $image = new SimpleImage();
            $success = $image->load($url);
            if ($success) {
                if (isset($minWidth) && isset($minHeight)) {
                    if ($minWidth > $image->getWidth() || $minHeight > $image->getHeight()) {
                        $data['error'] = "Минимальный размер {$minWidth}x{$minHeight}";
                        $data = json_encode($data);
                        die($data);
                    }
                }
                if (isset($setWidth) && isset($setHeight)) {
                    $image->cutToSize($setWidth, $setHeight);
                }
                $image->save($newname);
                $data['data'] = $newname . "?" . time();
                $data = json_encode($data);
                die($data);
            } else {
                $data['error'] = 'Ошибка загрузки изображения';
                $data = json_encode($data);
                die($data);
            }

            break;

        default:
            //Загрузка локальных изображений
            $filename = stripslashes($_FILES['photos']['name']);
            $tmpname = $_FILES['photos']['tmp_name'];
            $size = filesize($_FILES['photos']['tmp_name']);
            $filetype = $_FILES['photos']['type'];
            if (isset($_POST['minWidth']) || isset($_POST['minHeight'])) {
                list($i_width, $i_height, $type) = getimagesize($tmpname);
                $minWidth = $_POST['minWidth'];
                $minHeight = $_POST['minHeight'];
                if ($minWidth > $i_width || $minHeight > $i_height) {
                    $data['error'] = "Минимальный размер {$minWidth}x{$minHeight}";
                    $data = json_encode($data);
                    die($data);
                }
            }

            //get the extension of the file in a lower case format
            $ext = strtolower(getExtension($filename));

            //Проверка на содержание PHP Файла
            $pos = strpos($filename, 'php');
            if (!($pos === false)) {
                $data['error'] = 'Ошибка загрузки изображения 1';
                $data = json_encode($data);
                die($data);
            }
            //Получить расширение файла
            $file_ext = strrchr($filename, '.');
            //Проверка типа файла
            $pos = strpos($filetype, 'image');
            if ($pos === false) {
                $data['error'] = 'Ошибка загрузки изображения 2';
                $data = json_encode($data);
                die($data);
            }
            if ($filetype != 'image/gif' && $filetype != 'image/jpeg' && $filetype != 'image/jpg' && $filetype != 'image/png') {
                $data['error'] = 'Ошибка загрузки изображения 3';
                $data = json_encode($data);
                die($data);
            }
            //Проверка дублирования расширения файла (image with comment)
            if (substr_count($filetype, '/') > 1) {
                $data['error'] = 'Ошибка загрузки изображения 4';
                $data = json_encode($data);
                die($data);
            }
            //Проверка допустимых расширений
            if (in_array($ext, $whitelist)) {
                if ($size < (MAX_SIZE * 1024 * 1024)) {

                    $image_name = 'picture.jpg';
                    if (isset($_POST['image_name'])) {
                        $image_name = $_POST['image_name'] . '.jpg';
                    }

                    $newname = $uploaddir . $image_name;

                    if (move_uploaded_file($_FILES['photos']['tmp_name'], $newname)) {
                        if (isset($setWidth) && isset($setHeight)) {
                            $image = new SimpleImage();
                            $image->load($newname);
                            $image->cutToSize($setWidth, $setHeight);
                            $image->save($newname);
                        }
                        $data['data'] = $newname . "?" . time();
                        $data = json_encode($data);
                        die($data);
                    } else {
                        $data['error'] = 'Ошибка копирования файла';
                        $data = json_encode($data);
                        die($data);
                    }
                } else {
                    $data['error'] = 'Превышен размер файла';
                    $data = json_encode($data);
                    die($data);
                }
            } else {
                $data['error'] = 'Неверное расширение файла';
                $data = json_encode($data);
                die($data);
            }
            break;
    }
    
}
