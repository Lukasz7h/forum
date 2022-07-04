<?php

    session_start();

    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/authorize.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/detail/php/comment/authorizeComm.php");

    class DeleteComm extends AuthorizeComm
    {
        //jeśli użytkownik jest autoryzowany do usunięcia komentarza to przechodzimy od jego usuwania
        public function __construct(int $comm_id, int $post_id)
        {
            if($this->autorizeToDo($comm_id)) $this->deleteComm($comm_id, $post_id);
        }

        //usuwamy odpowiedni komentarz z bazy danych
        private function deleteComm(int $comm_id, int $post_id)
        {
            $connect = $this->createConnect();
            $query = "DELETE FROM comments WHERE id = $comm_id";

            $connect->query($query);
            $query = "UPDATE users_posts SET comm_amount = comm_amount - 1 WHERE id=$post_id";

            $connect->query($query);
            echo true;

            $connect->close();
        }
    }

    //jeśli użytkownik jest zalogowany przechodzimy do jego autoryzacji
    if(isset($_POST["comm_id"]) && $_POST["post_id"])
    {
        if(!authorize($_SESSION["user_login"])) return;
        $delete = new DeleteComm(intval($_POST["comm_id"]), intval($_POST["post_id"]));
    }
?>