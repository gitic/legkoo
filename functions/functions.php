<?php

/* ===Распечатка массива=== */
function print_arr($arr){
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}
/* ===Распечатка массива=== */

/* ===Возраст по дате рождения=== */
function get_age($birthday) {
  $birthday_timestamp = strtotime($birthday);
  $age = date('Y') - date('Y', $birthday_timestamp);
  if (date('md', $birthday_timestamp) > date('md')) {
    $age--;
  }
  return $age;
}
/* ===Возраст по дате рождения=== */

/* ===Фильтрация входящих данных=== */
function clear(mysqli $conn,$var){
    $var = mysqli_real_escape_string($conn, trim($var));
    return $var;
}
/* ===Фильтрация входящих данных=== */

/* ===Редирект=== */
function redirect($http = false){
    if($http) $redirect = $http;
        else    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    header("Location: $redirect");
    exit;
}
/* ===Редирект=== */

/* ===Отправка Email с кодом активации=== */
/**
 * @param type $email email пользователя
 * @param type $subject тема письма
 * @param type $message сообщение
 * @return boolean
 */
function sendMail($email,$subject,$message){
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "From: no-reply@".$_SERVER['HTTP_HOST']."\r\n";
    
    $success = mail($email, $subject, $message, $headers);//отправляем сообщение
    if(!$success){return false;}
    return true;
}
/* ===Отправка Email с кодом активации=== */

/* ===Хэшируем пароль=== */
/**
 * Возвращает захешированный пароль
 * @param type $password
 * @return string 
 */
function hashPassword($password){
    $password = md5($password);//шифруем пароль
    $password = strrev($password);// для надежности добавим реверс
    $password = $password."9q8w7e3";
    return $password;
}
/* ===Хэшируем пароль=== */

/* ===Рекурсивное удаление папки с файлами=== */
function delDir($folder) {
    if (is_dir($folder)) {
        $handle = opendir($folder);
        while ($subfile = readdir($handle)) {
            if ($subfile == '.' or $subfile == '..') continue;
            if (is_file($subfile)) unlink("{$folder}/{$subfile}");
            else delDir("{$folder}/{$subfile}");
        }
        closedir($handle);
        rmdir($folder);
    } else
        unlink($folder);
}
/* ===Рекурсивное удаление папки с файлами=== */

/**
 * Делает первую букву заглавной
 * @param type $text
 * @return type String
 */
function mb_ucfirst($text) {
    mb_internal_encoding("UTF-8");
    $text = mb_strtolower($text);
    return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
}
/* ===Транслит=== */
function translitIt($str) {
    $tr = array(
            "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
            "Д"=>"D","Е"=>"E","Ё"=>"Yo","ё"=>"yo","Ж"=>"J","З"=>"Z","И"=>"I",
            "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
            "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
            "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
            "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
            "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
            "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
            "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
            "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
            "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
            "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
            "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
            "%"=>"",":"=>"","?"=>"","*"=>"","<"=>"",">"=>"","("=>"",")"=>"","«"=>"","»"=>"","’"=>"",
            "|"=>""," "=>"-","'"=>"","\""=>"","\\"=>"","."=>"","+"=>"","_"=>"-","—"=>"-","™"=>"","!"=>"",
            "!"=>"", "@"=>"", "#"=>"", "$"=>"", "^"=>"", "&"=>"", "{"=>"", "}"=>"", "["=>"", "]"=>"", "/"=>"", ","=>"-",
            "`"=>"", "~"=>"-", "®"=>'');
    $str = strtr($str,$tr);	
    return $str;
}
/* ===Транслит=== */

/* ===Текущий URL страницы=== */
function request_url()
{
  $result = ''; // Пока результат пуст
  $default_port = 80; // Порт по-умолчанию
 
  // А не в защищенном-ли мы соединении?
  if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=='on')) {
    // В защищенном! Добавим протокол...
    $result .= 'https://';
    // ...и переназначим значение порта по-умолчанию
    $default_port = 443;
  } else {
    // Обычное соединение, обычный протокол
    $result .= 'http://';
  }
  // Имя сервера, напр. site.com или www.site.com
  $result .= $_SERVER['SERVER_NAME'];
 
  // А порт у нас по-умолчанию?
  if ($_SERVER['SERVER_PORT'] != $default_port) {
    // Если нет, то добавим порт в URL
    $result .= ':'.$_SERVER['SERVER_PORT'];
  }
  // Последняя часть запроса (путь и GET-параметры).
  $result .= $_SERVER['REQUEST_URI'];
  // Уфф, вроде получилось!
  return $result;
}
/* ===Текущий URL страницы=== */

/* ===Отправка Email через SMTP=== */
/**
 * Функция для отправки почты через ssl Gmail
 * @param type $from_name от кого пишем письмо
 * @param type $to_mail адрес получателя (можно указать через запятую)
 * @param type $subject тема сообщения
 * @param type $message текст сообщения
 * @return boolean (true/false)
 */
function sendSMTPgmail($from_name,$to_mail,$subject,$message){
    $mailSMTP = new SendMailSmtpClass(MAIL, MAIL_PASS, 'ssl://smtp.gmail.com', $from_name, 465);                      
    // заголовок письма
    $headers= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n"; // кодировка письма
    $headers .= "From: $from_name <".MAIL.">\r\n"; // от кого письмо
    $result =  $mailSMTP->send($to_mail, $subject, $message, $headers); // отправляем письмо
    // $result =  $mailSMTP->send('Кому письмо', 'Тема письма', 'Текст письма', 'Заголовки письма');
    return $result;
}
/* ===Отправка Email через SMTP=== */

function templateNewOrder($title,$orderHref,$name,$email,$phone,$comment,$sum,$discountSum,$deliverySum,$totalSum,$products){
    $pText = '';
    foreach ($products as $product) {
        $pText .= '<tr>
                        <td style="border-bottom:1px solid #cccccc;padding:7px;vertical-align:top;text-align:left">'.$product['articul'].'</td>
                        <td style="border-bottom:1px solid #cccccc;padding:7px;vertical-align:top;text-align:left;width:50px">
                                <img src="http://legkoo.com.ua/'.$product['img'].'" style="width:50px">
                        </td>
                        <td style="border-bottom:1px solid #cccccc;padding:7px;vertical-align:top;text-align:left">
                                <div>'.$product['title'].'</div>
                        </td>
                        <td style="border-bottom:1px solid #cccccc;padding:7px;vertical-align:top;text-align:left">'.$product['count'].'</td>
                        <td style="border-bottom:1px solid #cccccc;padding:7px;vertical-align:top;text-align:left">'.$product['price'].' грн</td>
                </tr>';
    }
    return '
<table border="0" cellpadding="0" cellspacing="0" width="70%" align="center">
    <tbody>
            <tr>
                    <td>
                            <div style="border:1px solid #b6b6b6;background:#fff;border-top:3px solid #4285cc;border-radius:0 0 6px 6px">
                                    <div style="padding:15px 25px">
                                            <div style="font-size:12px;font-family:tahoma">
                                                    <div style="font-weight:bold;font-size:14px;padding:0 0 10px;margin:0 0 10px;border-bottom:1px solid #b6b6b6">
                                                            '.$title.'
                                                    </div>
                                                    <div style="font-size:11px;font-weight:normal">
                                                            <a href="'.$orderHref.'">Ссылка на заказ в панели администрирования</a>
                                                    </div>
                                                    <div>
                                                            <div style="padding:10px 0 5px;font-weight:bold">Информация о покупателе</div>
                                                            <table cellpadding="5" cellspacing="0" style="font-size:12px;font-family:tahoma">
                                                                    <tbody>
                                                                            <tr>
                                                                                    <td style="color:#665;width:150px">Имя</td>
                                                                                    <td>'.$name.'</td>
                                                                            </tr>
                                                                            <tr>
                                                                                    <td style="color:#665;width:150px">E-mail</td>
                                                                                    <td><a href="mailto:'.$email.'">'.$email.'</a></td>
                                                                            </tr>
                                                                            <tr>
                                                                                    <td style="color:#665;">Телефон</td>
                                                                                    <td><a href="tel:'.$phone.'" value="'.$phone.'" target="_blank">'.$phone.'</a></td>
                                                                            </tr>
                                                                            <tr>
                                                                                    <td style="color:#665;width:150px">Комментарий клиента</td>
                                                                                    <td>'.$comment.'</td>
                                                                            </tr>
                                                                    </tbody>
                                                            </table>
                                                    </div>
                                                    <div>
                                                            <div style="padding:10px 0 5px;font-weight:bold">Заказанные товары</div>
                                                            <table cellpadding="0" cellspacing="0" style="width:100%;font-size:11px">
                                                                    <thead>
                                                                            <tr>
                                                                                    <td width="10%" style="border-top:1px solid #cccccc;border-bottom:1px solid #cccccc;background:#efefef;color:#366ab8;font-weight:bold;padding:7px">Артикул</td>
                                                                                    <td colspan="2" style="border-top:1px solid #cccccc;border-bottom:1px solid #cccccc;background:#efefef;color:#366ab8;font-weight:bold;padding:7px">Название</td>
                                                                                    <td width="10%" style="border-top:1px solid #cccccc;border-bottom:1px solid #cccccc;background:#efefef;color:#366ab8;font-weight:bold;padding:7px">Количество</td>
                                                                                    <td width="15%" style="border-top:1px solid #cccccc;border-bottom:1px solid #cccccc;background:#efefef;color:#366ab8;font-weight:bold;padding:7px">Цена</td>
                                                                            </tr>
                                                                    </thead>
                                                                    <tbody>'.$pText.'</tbody>
                                                            </table>
                                                    </div>
                                                    <div>
                                                            <div style="padding:10px 0 5px;font-weight:bold">Сумма заказа</div>
                                                            <table cellpadding="5" cellspacing="0" style="font-size:12px;font-family:tahoma">
                                                                    <tbody>
                                                                            <tr>
                                                                                    <td style="color:#665;width:150px">Товары</td>
                                                                                    <td>'.$sum.' грн</td>
                                                                            </tr>
                                                                            <tr>
                                                                                    <td style="color:#665;">Скидка</td>
                                                                                    <td>'.$discountSum.' грн</td>
                                                                            </tr>
                                                                            <tr>
                                                                                    <td style="color:#665;">Доставка</td>
                                                                                    <td>'.$deliverySum.' грн</td>
                                                                            </tr>
                                                                            <tr>
                                                                                    <td style="color:#665;font-weight:bold">Всего</td>
                                                                                    <td>'.$totalSum.' грн</td>
                                                                            </tr>
                                                                    </tbody>
                                                            </table>
                                                    </div>
                                            </div>
                                    </div>
                            </div>
                    </td>
            </tr>
    </tbody>
</table>
';}
