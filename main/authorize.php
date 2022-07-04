<?php

    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/propertyDB.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/login/php/updateKey.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/clearHTML.php");

    $host = $_SERVER["SERVER_NAME"];

    class Authorize extends Connect
    {

        //sprawdzamy czy dla któregoś z kont istnieje podany klucz jeśli tak do sesji trafiają informacje z tego konta a sam klucz jest zmieniany
        public function authorizeUser($user_key)
        {
            $connect = $this->createConnect();

            $query = "SELECT users_key.id_user, users.login, bans.banTime FROM users 
            INNER JOIN(users_key) INNER JOIN(bans) ON users.id = users_key.id_user AND bans.user_id = users_key.id_user AND users_key.user_key = ?";

            $prepare_query = $connect->prepare($query);

            $prepare_query->bind_param("s", $user_key);
            $prepare_query->bind_result($id_user, $login, $banTime);

            $prepare_query->execute();
            $prepare_query->store_result();

            if($prepare_query->num_rows > 0)
            {
                while($prepare_query->fetch())
                {
                    $_SESSION["user_id"] = $id_user;
                    $_SESSION["user_login"] = clearHTML($login);

                    setcookie("PHPSESSID", session_id(), 0, "/", "", httponly: true);
                    $_SESSION["lastCommentDate"] = [];

                    $res = (object) array("login" => $_SESSION["user_login"]);
                    if($banTime)
                    {
                        $res->ban = $banTime;
                        $res->can = 0;
                    }
                    else{
                        $res->can = 1;
                    };

                    $update = new UpdateKey($id_user);
                    return $res;
                    
                };
            };

            $prepare_query->close();
            $connect->close();
        }
    }
?>