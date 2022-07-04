<?php

    session_start();

    //jeśli zostało wysłane żądanie metodą post (co świadczy o tym że użytkownik wyszedł ze strony) tworzymy ciastko które zawiera klucz potrzebny do otworzenia naszej następnej sesji
    if(isset($_POST))
    {
        if(isset($_SESSION["user_key"]))
        {
            setcookie("user_key", $_SESSION["user_key"], time()+3600*24*7, "/", "localhost", httponly: true);
        };
    };
?>