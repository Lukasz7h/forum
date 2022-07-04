<?php

    session_start();
    require_once($_SERVER["DOCUMENT_ROOT"]."/forum/propertyDB.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/forum/login/php/updateKey.php");

    class Check extends Connect
    {
        public function __construct($login, $password)
        {
            $this->chars($login, $password);
        }

        //sprawdzamy czy wartości z rejestracji zaczynają się lub kończą od spacji
        private function chars($login, $password)
        {
            $loginFirst = substr($login, 0, 1);
            $loginLast = substr($login, strlen($login) - 1, 1);

            $passwordFirst = substr($password, 0, 1);
            $passwordLast = substr($password, strlen($password) - 1, 1);

            if($loginFirst === " " || $loginLast === " " || $passwordFirst === " " || $passwordLast === " ")
            {
                return "err";
            }

            $this->dataIsWell($login, $password);
        }

        //sprawdzamy czy podane dane się zgadzają i zwracamy komunikat o przebiegu logowania (jeśli dane się zgadzają tworzymy nowy klucz użytkownika)
        private function dataIsWell($login, $password)
        {
            $salt = "H98h^&^ffjgRUR(*7798TDFgd98assa46)&*^(gHJt&^87^%(wd4ag(T*Rd8AL9(&awwdF8F8F";
            $hash_password = hash("SHA512", $password.$salt);

            $connect = $this->createConnect();
            $query = "SELECT id, login FROM users WHERE login = ? AND password = ?";

            $preapare_query = $connect->prepare($query)or die(self::SERV_ERR);
            $preapare_query->bind_param("ss", $login, $hash_password);

            $preapare_query->bind_result($id, $login);
            $preapare_query->execute();

            $preapare_query->store_result();
            if($preapare_query->num_rows > 0)
            {
               while($preapare_query->fetch())
               {
                    $_SESSION["user_id"] = $id;
                    $_SESSION["user_login"] = $login;

                    setcookie("PHPSESSID", session_id(), 0, "/", "", httponly: true);
                    $update = new UpdateKey($id); //tu tworzymy klucz

                    $_SESSION["lastCommentDate"] = [];
                    echo "ok";
               }
            }
            else
            {
                echo "err";
            }
        }
    }
?>