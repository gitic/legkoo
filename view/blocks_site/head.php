<?php

//проверка доступа

defined(ACCESS_VALUE) or die('Access denied');

?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="user-scalable=no, initial-scale = 1, minimum-scale = 1, maximum-scale = 1, width=device-width" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />

<meta name='yandex-verification' content='401582a70e4711f0' />

<link rel="shortcut icon" href="<?=VIEW?>images/favicon.png">
<link rel="stylesheet" type="text/css" href="<?=VIEW?>css/style.css?<?=time()?>" />
<link rel="stylesheet" type="text/css" href="<?=VIEW?>css/media.css?<?=time()?>" />
<link rel='stylesheet' href='lib/icons/css/font-awesome.min.css'>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,700,900&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,700,300&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800&amp;subset=latin,cyrillic" rel="stylesheet" type="text/css">

<script src="lib/jquery-1.11.2.min.js"></script>
<script src="lib/jquery.cookie.js"></script>
<link href="lib/jquery-ui/jquery-ui.min.css" rel="stylesheet">
<script src="lib/jquery-ui/jquery-ui.min.js"></script>
<script src="lib/touch-punch.js"></script>
<script src="lib/jquery.elevate_zoom-2.2.3.min.js"></script>
<script src="lib/jquery.scrollUp.js"></script>
<script src="<?=VIEW?>js/mainJs.js"></script>

<script>
    $(function() {
            var pull 		= $('#pull');
                    menu 		= $('nav ul');
                    menuHeight	= menu.height();

            $(pull).on('click', function(e) {
                    e.preventDefault();
                    menu.slideToggle();
            });

            $(window).resize(function(){
            var w = $(window).width();
            if(w > 300 && menu.is(':hidden')) {
                    menu.removeAttr('style');
            }
    });
    });
    $(function () {
        $.scrollUp({
            animation: 'fade',
            scrollText: 'НАВЕРХ',
            topSpeed: 600,
        });
    });

</script>
