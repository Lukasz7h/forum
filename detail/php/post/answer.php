<?php

session_start();
require_once($_SERVER["DOCUMENT_ROOT"]."../forum/propertyDB.php");

class SetAnswer extends Connect
{
    //sprawdzamy czy podany użytkownik jest właścicielem postu jeśli tak to zmieniamy status postu na rozwiązany
    function __construct(int $answerID)
    {
        $canModify = new Authorize();
        $canModify->modifyPost($_SESSION["user_id"], $_SESSION["post_id"]);

        $connect = $this->createConnect();
        $query = "UPDATE comments SET is_solution = 1 WHERE id = $answerID AND id_post = ".$_SESSION["post_id"]."";

        $connect->query($query);

        $query = "SELECT id_user FROM comments WHERE id = $answerID";
        $res = $connect->query($query);

        $row = $res->fetch_row();
        $thatUserId = $row[0];

        $query = "UPDATE scores SET scores = scores + 70 WHERE id_user = '$thatUserId'";
        $connect->query($query);

        $query = "INSERT INTO solved(id, topic, post_value, photo_dir, user_id, post_date) SELECT id, topic, post_value, photo_dir, user_id, post_date FROM users_posts WHERE id = ".$_SESSION["post_id"]."";
        $connect->query($query);

        $query = "DELETE FROM users_posts WHERE id = ".$_SESSION["post_id"]."";
        $connect->query($query);

        $connect->close();
    }
}

require_once($_SERVER["DOCUMENT_ROOT"]."../forum/authorize.php");

    //sprawdzmy czy użytkownik który wysłał informacje o poprawnej odpowiedzi dla postu jest zalogowany
    if(isset($_POST["answer"]))
    {
        if(!authorize($_SESSION["user_id"])) return;
        $answerID = intval($_POST["answer"]);

        $answer = new SetAnswer($answerID);
    }
?>