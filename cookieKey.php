<?php
    session_start();
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/main/authorize.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/propertyDB.php");

    class UserInform extends Connect
    {

        // sprawdzamy czy ban się skończył i jeśli tak zmieniamy dane w bazie danych
        public function get(string $user_id, $send)
        {
            $connect = $this->createConnect();
            $query = "SELECT canComment, banTime FROM bans WHERE user_id = '$user_id'";

            $res = $connect->query($query);
            $rows = $res->fetch_row();

            $currentDate = new DateTime("", new DateTimeZone("Europe/Warsaw"));
            $banDate = strtotime($rows[1]);

            $currentDate = strtotime($currentDate->format('Y-m-d H:i:s'));
            if($currentDate > $banDate)
            {
                $query = "UPDATE bans SET canComment = 1, banTime = 0 WHERE user_id = '".$_SESSION["user_id"]."'";
                $connect->query($query);

                $send->can = 1;
            };

            if($res)
            {
                echo json_encode($send);
            };

            $connect->close();
        }
    };

    //jeśli użytkownik tylko odświerzył stronę i był zalogowany zwracamy przypisaną mu sesje z loginem
    if(isset($_SESSION["user_login"]))
    {
        $userInfo = new UserInform();

        if(isset($_SESSION["user_key"])) 
        {
            $authorize = new Authorize();
            $res = $authorize->authorizeUser($_SESSION["user_key"]);

            $userInfo->get($_SESSION["user_id"], $res);
        };
        
        //jeśli istnieje ciasteczko z kluczem niszczymy je
        if(isset($_COOKIE["user_key"])) setcookie("user_key", "", time()-3600, "/", "");
    }
    //jeśli użytkownik włączył stronę i istnieje na jego urządzeniu ciastko z kluczem to przekazujemy klucz do sesji i usuwamy ciastko a następnie sprawdzamy czy klucz jest właściwy
    else if(isset($_COOKIE["user_key"]))
    {
       $_SESSION["user_key"] = $_COOKIE["user_key"];

       $authorize = new Authorize();
       $res = $authorize->authorizeUser($_SESSION["user_key"]);

       setcookie("user_key", "", time()-3600, "/", "localhost");

       $userInfo = new UserInform();
       $userInfo->get($_SESSION["user_id"], $res);
    };
?>