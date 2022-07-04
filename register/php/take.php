<?php

    require_once("../php/check.php");

    //jeśli dane z formularza zostały przesłane zostaje rozpoczęta procedura sprawdzenia ich
    if(isset($_POST["data"]))
    {
        $data = json_decode($_POST["data"]);

        $login = $data->login;
        $password = $data->password;

        $r_password = $data->r_password;
        $captcha = $data->captcha;

        $check = new Check();
        echo $check->canSave($login, $password, $r_password, $captcha);
    }
?>