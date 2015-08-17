<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

if(isset($_COOKIE["leguida"]) && !isset($_SESSION['admin'])){
    $_SESSION['admin'] = $_COOKIE["leguida"];
}
            
if(!isset($_SESSION['admin'])){
    require_once ('login_form.php');
    die();
}
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <?php require_once 'blocks_site/head.php';?>       
    </head>
    <body>
        <div id="wrap">
	
		<?php require_once ('blocks_site/menu.php');?>
			
		<div id="main">
			<?php require_once $view.'.php';?>
		</div>
		<div class="clear"></div>
	</div>
    </body>
</html>
