<?php

    require_once("../year/check.php");
    require_once("../year/getThatMonth.php");

    require_once("../year/err.php");

    if(isset($_GET["month"]))
    {
       $month = $_GET["month"];
       $check_month = new CheckMonth();

       $g = new Month();

       $access = $check_month->isAccessMonth($month); //sprawdzamy czy podany miesiąc jest właściwy
       $access? $g->getMonth($month): errMonth(); //wypisujemy posty dotyczące podanego miesiąca lub informujemy o błędzie
    }
?>