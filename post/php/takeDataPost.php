<?php

    require_once($_SERVER["DOCUMENT_ROOT"]."/forum/propertyDB.php");
    require_once("../php/save.php");

    require_once("../php/checkValue.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/authorize.php");

    // odbieramy dane o poście
    if(isset($_POST["data"]))
    {
        if(!authorize($_SESSION["user_login"])) return;

        $data = json_decode($_POST["data"]);

        $topic = $data->topic;
        $post_value = $data->post_value;

        $resOfCheck = checkValue([$topic, $post_value]);
        
        $save = new Save();
        echo !$resOfCheck? $save->savePost($topic, $post_value): "empty_value";
    }
?>