<?php

    require_once("../php/check.php");

    //po wysłaniu danych z logowania odbieramy je tutaj i wysyłamy do sprawdzenia
    if(isset($_POST["data"]))
    {
        $data = json_decode($_POST["data"]);

        $login = $data->login;
        $password = $data->password;

        $check = new Check($login, $password);
    }
?>