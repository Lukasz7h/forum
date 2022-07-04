<?php

    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/authorize.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/propertyDB.php");

    class AuthorizeComm extends Connect
    {
        //funkcja ta sprawdza czy osoba która chce zmodyfikować, dodać lub usunąć jakąs wartość komentarza ma do tego autoryzacje
        protected function autorizeToDo(int $id)
        {
            $connect = $this->createConnect();
            $query = "SELECT id_user FROM comments WHERE id = ?";

            $prepare_query = $connect->prepare($query);
            $prepare_query->bind_param("s", $id);

            $prepare_query->bind_result($id_user);
            $prepare_query->execute();

            $flag = false;

            while($prepare_query->fetch())
            {
                if($_SESSION["user_id"] === $id_user) $flag = true;
            };

            $prepare_query->close();
            $connect->close();

            return $flag;
        }
    }
?>