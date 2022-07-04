<?php 
    session_start();
    $host = $_SERVER["SERVER_NAME"];
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani&display=swap" rel="stylesheet"> 
    <title>Forum</title>
</head>
<body>
    <header></header>
    <button id="solved"><a href="../resolved/">Rozwiązane problemy</a></button>
    <article>
        <div><a href="http://<?php echo $host?>/forum/year/month.php?month=styczeń"><h4>Styczeń</h4>
        <?php $month = '01'; require("./bestAtMonth.php"); ?>
        </a></div>
        <div><a href="http://<?php echo $host?>/forum/year/month.php?month=luty"><h4>Luty</h4>
        <?php $month = '02'; require("./bestAtMonth.php"); ?>
        </a></div>
        <div><a href="http://<?php echo $host?>/forum/year/month.php?month=marzec"><h4>Marzec</h4>
        <?php $month = '03'; require("./bestAtMonth.php"); ?>
        </a></div>
        <div><a href="http://<?php echo $host?>/forum/year/month.php?month=kwiecień"><h4>Kwiecień</h4>
        <?php $month = '04'; require("./bestAtMonth.php"); ?>
        </a></div>
        <div><a href="http://<?php echo $host?>/forum/year/month.php?month=maj"><h4>Maj</h4>
        <?php $month = '05'; require("./bestAtMonth.php"); ?>
        </a></div>
        <div><a href="http://<?php echo $host?>/forum/year/month.php?month=czerwiec"><h4>Czerwiec</h4>
        <?php $month = '06'; require("./bestAtMonth.php"); ?>
        </a></div>
        <div><a href="http://<?php echo $host?>/forum/year/month.php?month=lipiec"><h4>Lipiec</h4> 
        <?php $month = '07'; require("./bestAtMonth.php"); ?>
        </a></div>
        <div><a href="http://<?php echo $host?>/forum/year/month.php?month=sierpień"><h4>Sierpień</h4>
        <?php $month = '08'; require("./bestAtMonth.php"); ?>
        </a></div>
        <div><a href="http://<?php echo $host?>/forum/year/month.php?month=wrzesień"><h4>Wrzesień</h4>
        <?php $month = '09'; require("./bestAtMonth.php"); ?>
        </a></div>
        <div><a href="http://<?php echo $host?>/forum/year/month.php?month=październik"><h4>Październik</h4>
        <?php $month = '10'; require("./bestAtMonth.php"); ?>
        </a></div>
        <div><a href="http://<?php echo $host?>/forum/year/month.php?month=listopad"><h4>Listopad</h4>
        <?php $month = '11'; require("./bestAtMonth.php"); ?>
        </a></div>
        <div><a href="http://<?php echo $host?>/forum/year/month.php?month=grudzień"><h4>Grudzień</h4>
        <?php $month = '12'; require("./bestAtMonth.php"); ?>
        </a></div>
    </article>
</body>
<div id="simplecookienotification_v01" style="display: block; z-index: 99999; min-height: 35px; width: 100%; position: fixed; background: rgb(255, 243, 224) none repeat scroll 0% 0%; border-image: none 100% / 1 / 0 stretch; border-top: 1px solid rgb(255, 152, 0); text-align: center; right: 0px; color: rgb(119, 119, 119); bottom: 0px; left: 0px; border-color: rgb(255, 152, 0); box-shadow: black 0px 8px 6px -6px; border-radius: 10px;">
<div style="padding:10px; margin-left:15px; margin-right:15px; font-size:14px; font-weight:normal;">
<span id="simplecookienotification_v01_powiadomienie">Ta strona używa plików cookies.</span><span id="br_pc_title_html"><br></span>
<a id="simplecookienotification_v01_polityka" href="http://jakwylaczyccookie.pl/polityka-cookie/" style="color: rgb(255, 152, 0);">Polityka Prywatności</a><span id="br_pc2_title_html"><br></span>
<a id="simplecookienotification_v01_info" href="http://jakwylaczyccookie.pl/jak-wylaczyc-pliki-cookies/" style="color: rgb(255, 152, 0);">Jak wyłączyć cookies?</a><span id="br_pc3_title_html"><br></span>
<a id="simplecookienotification_v01_info2" href="https://nety.pl/cyberbezpieczenstwo" style="color: rgb(255, 152, 0);">Cyberbezpieczeństwo</a><div id="jwc_hr1" style="height: 10px; display: none;"></div>
<a id="okbutton" href="javascript:simplecookienotification_v01_create_cookie('simplecookienotification_v01',1,7);" style="position: absolute; background: rgb(255, 152, 0) none repeat scroll 0% 0%; color: rgb(255, 255, 255); padding: 5px 15px; text-decoration: none; font-size: 12px; font-weight: normal; border: 0px solid rgb(255, 243, 224); border-radius: 5px; top: 5px; right: 5px;">AKCEPTUJĘ</a><div id="jwc_hr2" style="height: 10px; display: none;"></div>
</div>
</div>
<script type="text/javascript">var galTable= new Array(); var galx = 0;</script>
<script type="text/javascript">function simplecookienotification_v01_create_cookie(name,value,days) { if (days) { var date = new Date(); date.setTime(date.getTime()+(days*24*60*60*1000)); var expires = "; expires="+date.toGMTString(); } else var expires = ""; document.cookie = name+"="+value+expires+"; path=/"; document.getElementById("simplecookienotification_v01").style.display = "none"; } function simplecookienotification_v01_read_cookie(name) { var nameEQ = name + "="; var ca = document.cookie.split(";"); for(var i=0;i < ca.length;i++) { var c = ca[i]; while (c.charAt(0)==" ") c = c.substring(1,c.length); if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length); }return null;}var simplecookienotification_v01_jest = simplecookienotification_v01_read_cookie("simplecookienotification_v01");if(simplecookienotification_v01_jest==1){ document.getElementById("simplecookienotification_v01").style.display = "none"; }</script>

<script type="module" src="main.js"></script>
    
    <?php
        require_once("../createCookie.php");
    ?>
</html>