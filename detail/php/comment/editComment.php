<?php

    session_start();

    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/authorize.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/detail/php/comment/authorizeComm.php");

    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/checkValue.php");

    class Edit extends AuthorizeComm
    {
        //jeśli użytkownik jest autoryzowany do edytowania podanego komentarza to też przechodzimy do jego edycji
        function __construct(string $edit, int $id)
        {
            $id = intval($id);
            if(!emptySpace($edit))
            {
                if($this->autorizeToDo($id)) $this->editComm($id, $edit);
            };
        }

        //edytujemy wartość komentarza o podanych id w bazie danych
        private function editComm(int $id, string $edit)
        {
            $connect = $this->createConnect();
            $query = "UPDATE comments SET comment_value = ? WHERE id = $id";

            $prepare_query = $connect->prepare($query);
            $prepare_query->bind_param("s", $edit);

            $prepare_query->execute();

            $prepare_query->close();
            $connect->close();
        }
    }

    //jeśli użytkownik jest zalogowany przechodzimy do jego autoryzacji
    if(isset($_POST["edit"]))
    {
        if(!authorize($_SESSION["user_login"])) return;
        $edit = new Edit($_POST["edit"], $_POST["id"]);
    }
?>