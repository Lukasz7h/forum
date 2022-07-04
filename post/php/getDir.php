<?php

    //zwracamy tablice z nazwami plików lub '0'
    function getDir()
    {
        if(isset($_SESSION["files_".$_SESSION["user_login"]]))
        {
            $arr = $_SESSION["files_".$_SESSION["user_login"]];

            unset($_SESSION["files_".$_SESSION["user_login"]]);
            return $arr;
        }
        else
        {
            return 0;
        }
    }
?>