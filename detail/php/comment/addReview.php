<?php

    session_start();

    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/authorize.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/propertyDB.php");

    class AddReview extends Connect
    {
        //sprawdzamy czy podana osoba już głosowała i czy przesyłana ocena jest taka sama jak wcześniejsza jeśli tak to nie zmieniamy ocen dla podanego komentarza a jeśli nie to modyfiikujemy oceny komentarza
        public function __construct(bool $flag, int $id)
        {
            $user_id = $_SESSION["user_id"];

            $connect = $this->createConnect();
            $query = "SELECT agree FROM users_review WHERE id_user = '$user_id' AND comment_id = $id";

            $res = $connect->query($query);
            if($res->num_rows === 0 || !$res)
            {
                $query = "SELECT is_agree, id_user FROM comments WHERE id = $id";

                $res = $connect->query($query);

                while($row = $res->fetch_row())
                {
                    $id_user = $row[1];
                    $that = $row[0];
                    $that++;
                }
    
                $flag? $query = "UPDATE comments SET is_agree = $that WHERE id = $id": $query = "UPDATE comments SET is_not_agree = $that WHERE id = $id";
                $connect->query($query);

                $flag? $flag = 1: $flag = 0;

                $query = "INSERT INTO users_review(id, comment_id, id_user, agree) VALUES(0, $id, '$user_id', $flag)";
                $connect->query($query);

                $flag?
                $query = "UPDATE scores SET scores = scores + 20 WHERE id_user = '$id_user'":
                $query = "UPDATE scores SET scores = scores - 20 WHERE id_user = '$id_user'";
                $connect->query($query);
            }
            else
            {

                while($row = $res->fetch_row())
                {
                    $agree = $row[0];
                    $agree == "1"? $agree = true: $agree = false; 
                };

                if($agree !== $flag)
                {
                    $flag === true? $flag = 1: $flag = 0;
                    $query = "UPDATE users_review SET agree = $flag WHERE id_user = '$user_id' AND comment_id = $id";
                    
                    $connect->query($query);

                    $query = "SELECT is_agree, is_not_agree, id_user FROM comments WHERE id = $id";
                    $res = $connect->query($query);

                    while($row = $res->fetch_row())
                    {
                        $agreeCount = $row[0];
                        $notAgreeCount = $row[1];

                        $id_user = $row[2];
                        $agree? [$agreeCount--, $notAgreeCount++]: [$agreeCount++, $notAgreeCount--];
                    };

                    $query = "UPDATE comments SET is_agree = $agreeCount, is_not_agree = $notAgreeCount WHERE id = $id";
                    $connect->query($query);

                    if($flag)
                    {
                        $query = "UPDATE scores SET scores = scores + 40 WHERE id_user = '$id_user'";
                        $connect->query($query);
                    }
                    else
                    {
                        $query = "UPDATE scores SET scores = scores - 40 WHERE id_user = '$id_user'";
                        $connect->query($query);
                    };
                };
            };
            $connect->close();
        }
    }

    //sprawdzamy czy został przesłana ocena i id komentarza i czy osoba wysyłająca ocene ma uprawnienia do dodawania jej
    if(isset($_POST["data"]) && isset($_POST["id"]))
    {
        if(!authorize($_SESSION["user_login"])) return;

        $flag = $_POST["data"];
        $id = intval($_POST["id"]);

        $flag === "true"? $flag = true: $flag = false;
        $add = new AddReview($flag, $id);
    }
?>