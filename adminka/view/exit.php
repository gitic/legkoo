<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

if (isset($_COOKIE['leguida'])) {
    unset($_COOKIE['leguida']);
    setcookie("leguida", '', time()-300);
}
unset($_SESSION['admin']);
echo '<script type="text/javascript">window.location = "?view=infopages"</script>';
