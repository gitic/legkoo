<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
?>
        <title>Панель администратора</title>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<link rel='stylesheet' type='text/css' href='<?=VIEW?>css/style.css' />
	<link rel='stylesheet' href='../lib/icons/css/font-awesome.min.css'>
	<link rel='shortcut icon' href='<?=VIEW?>images/favicon.png'>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800&amp;subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
        
        <script src="../lib/jquery-1.11.2.min.js"></script>
        <script src="../lib/jquery.cookie.js"></script>
        <script src="../lib/file_api/FileAPI.min.js"></script>
        <script src="../lib/file_api/FileAPI.exif.js"></script>
        <script src="../lib/file_api/jquery.fileapi.min.js"></script>
        <link href="../lib/jquery-ui/jquery-ui.min.css" rel="stylesheet">
        <script src="../lib/jquery-ui/jquery-ui.min.js"></script>
        <script src="<?=VIEW?>js/mainJs.js"></script>