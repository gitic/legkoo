<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

require_once 'lib/SendMailSmtpClass.php';

// Здесь нужно ввести свой адрес
$emailAddress = '';


// Используем сессию, чтобы предотвратить флудинг:

//session_name('quickFeedback');
//session_start();

// Если последняя форма была отправлена меньше 10 секунд назад,
// или пользователь уже послал 10 сообщений за последний час

//if(	$_SESSION['lastSubmit'] && ( time() - $_SESSION['lastSubmit'] < 10 || $_SESSION['submitsLastHour'][date('d-m-Y-H')] > 10 )){
//	die('Пожалуста, подождите несколько минут, прежде чем отправить соообщение снова.');
//}
//
//$_SESSION['lastSubmit'] = time();
//$_SESSION['submitsLastHour'][date('d-m-Y-H')]++;

if(ini_get('magic_quotes_gpc')){
	$_POST['message'] = stripslashes($_POST['message']);
}

if(mb_strlen($_POST['message'],'utf-8') < 5){
	die('Ваше сообщение слишком короткое.');
}

$msg = nl2br(strip_tags($_POST['message']));

sendSMTPgmail(TITLE, 'glink0504@gmail.com', 'Отзыв о сайте Legkoo.com.ua', $msg);

echo 'Спасибо!';
?>
