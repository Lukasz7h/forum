<?php

    require_once($_SERVER["DOCUMENT_ROOT"]."/forum/register/php/createID.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/forum/propertyDB.php");

    class Save extends Connect
    {

        //tworzymy hash hasła i dodajemy dane do bazy danych a następnie informujemy o udanej rejestracji
        protected function saveUser($login, $password)
        {
            $salt = "H98h^&^ffjgRUR(*7798TDFgd98assa46)&*^(gHJt&^87^%(wd4ag(T*Rd8AL9(&awwdF8F8F";
            $hash_password = hash("SHA512", $password.$salt);

            $ID = new CreateID();
            $id = $ID->createID();

            $connect = $this->createConnect();
            $query = "INSERT INTO users(id, login, password) VALUES(?, ?, ?)";

            $prepare_query = $connect->prepare($query) or die(self::SERV_ERR);
            $prepare_query->bind_param("sss", $id, $login, $hash_password);

            $prepare_query->execute();
            $prepare_query->close();

            $query = "INSERT INTO users_key(id_user, user_key) VALUES('$id', NULL)";
            $connect->query($query);

            $query = "INSERT INTO scores(id, id_user, scores) VALUES(0, '$id', 0)";
            $connect->query($query);

            $query = "INSERT INTO bans(user_id, canComment, banTime) VALUES('$id', 1, 0)";
            $connect->query($query);

            $connect->close();
            return "ok";
        }
    }
?>