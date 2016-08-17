<?php

//проверка доступа

defined(ACCESS_VALUE) or die('Access denied');

?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />

<meta name='yandex-verification' content='401582a70e4711f0' />

<link rel="shortcut icon" href="<?=VIEW?>images/favicon.png">
<link rel="stylesheet" type="text/css" href="<?=VIEW?>css/style.css?<?=time()?>" />
<link rel="stylesheet" type="text/css" href="<?=VIEW?>css/media.css?<?=time()?>" />
<link rel='stylesheet' href='lib/icons/css/font-awesome.min.css'>
<link rel="stylesheet" type="text/css" href="lib/feedback/styles.css" />
<link href='https://fonts.googleapis.com/css?family=Ubuntu:400,300,500,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

<script src="lib/jquery-1.11.2.min.js"></script>
<script src="lib/jquery.cookie.js"></script>
<link href="lib/jquery-ui/jquery-ui.min.css" rel="stylesheet">
<script src="lib/jquery-ui/jquery-ui.min.js"></script>
<link href="lib/slick/slick.css" rel="stylesheet">
<script src="lib/slick/slick.min.js"></script>
<script src="lib/touch-punch.js"></script>
<script src="lib/jquery.elevate_zoom-2.2.3.min.js"></script>
<script src="lib/jquery.scrollUp.js"></script>
<script src="lib/productTabs.js"></script>
<script src="lib/feedback/script.js"></script>
<script src="lib/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="lib/instagram/instafeed.min.js"></script>
<script src="<?=VIEW?>js/mainJs.js"></script>
<script src="<?=VIEW?>js/search.js"></script>

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
    $(function(){
        $(".phoneMask").mask("(999) 999-9999");
    });

</script>



<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-66844067-1', 'auto');
  ga('send', 'pageview');

</script>


<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');

fbq('init', '106997649750981');
fbq('track', "PageView");</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=106997649750981&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->