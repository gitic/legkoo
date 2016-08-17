<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

if(isset($_POST['submit'])){
    $login = $_POST['xlogin'];
    $pass = $_POST['xpass'];
    $result = $conn->query("SELECT * FROM admins WHERE login='$login' AND password='$pass' AND visible='1'");
    if($result->num_rows > 0){
        $record = $result->fetch_object();
        $_SESSION['admin'] = $login;
        setcookie("leguida", $record->id, time()+60*60*24*90);
        echo '<script type="text/javascript">window.location = "?view=info_pages"</script>';
        die();
    }
}
?>
﻿<!DOCTYPE html>
<html>

<head>
	<?php include ('blocks_site/head.php');?>
</head>

<body>

	<div id="wrap" style="width:100%;">
		<div id="login-form">
			<form method="post">
				<div>
					<label><i class="fa fa-user-secret"></i> Логин</label> <input type="text" name="xlogin" class="inp" placeholder="логин" />
				</div>
				<div>
					<label><i class="fa fa-unlock-alt"></i> Пароль</label> <input type="password" name="xpass" class="inp" placeholder="пароль" />
				</div>
				<input type="submit" name='submit' value="Войти" class="btn"/>
				<div class="clear"></div>
			</form>
		</div>
		
	</div>
	
</body>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter32188239 = new Ya.Metrika({
                    id:32188239,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/32188239" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</html>