<?php

    session_start();
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/propertyDB.php");

    class AddComment extends Connect
    {

        //jesli użytkownik jest adminem
        private function isAdmin(string $user_id, int $post_id, $connect)
        {
            $query = "SELECT user_id FROM users_posts WHERE id=$post_id";
            $res = $connect->query($query);

            $creator_id = $res->fetch_row()[0];

            if($creator_id == $user_id)
            {
                $query = "UPDATE users_posts SET comm_amount = comm_amount + 1 WHERE id=$post_id";
                $connect->query($query);
            };
        }

        // banujemy użytkownika
        private function blockUser($time)
        {
            $banTime = date_modify($time, "+ 2 hours");
            $banTime = $banTime->format('Y-m-d H:i:s');

            $connect = $this->createConnect();
            $query = "UPDATE bans SET canComment = 0, banTime = '$banTime' WHERE user_id='".$_SESSION["user_id"]."'";

            $connect->query($query);
            $connect->close();

            $response = (object) array("add" => true, "ban" => true, "time" => $banTime);
            echo json_encode($response);
            die;
        }

        // sprawdzamy czy zbanować użytkownik
        private function canBlockCommentForUser(array $timeArr)
        {
            $reveal = $timeArr[0]->diff($timeArr[4]);
            $secDiff = $reveal->s;

            $_SESSION["lastCommentDate"] = [];
            if($secDiff < 40) $this->blockUser($timeArr[0]);
        }

        //dodajemy nowy komentarz
        protected function addComment(string $task)
        {
            $user_id = $_SESSION["user_id"];
            $post_id = $_SESSION["post_id"];
            $user_login = $_SESSION["user_login"];

            $connect = $this->createConnect();
            $this->isAdmin($user_id, $post_id, $connect);

            $query = "SELECT canComment FROM bans WHERE user_id = '$user_id'";
            $res = $connect->query($query);

            $can = $res->fetch_row();
            $can = $can[0];

            $query = "SELECT id FROM comments WHERE id_post = $post_id AND is_solution = 1";
            $res = $connect->query($query);

            if(!$can || $res->num_rows > 0)
            {
                (object) array("add" => false, "ban" => false);
                die;
            };

            $query = "INSERT INTO comments(id, id_user, login_user, id_post, comment_value, is_solution, is_agree, is_not_agree, comment_date) VALUES(0, '$user_id', '$user_login', '$post_id', ?, 0, 0, 0, NOW())";

            $prepare_query = $connect->prepare($query);
            $prepare_query->bind_param("s", $task);

            $prepare_query->execute();
            $prepare_query->close();

            $connect->close();
            array_push($_SESSION["lastCommentDate"],  new DateTime('', new DateTimeZone("Europe/Warsaw")));

            if(count($_SESSION["lastCommentDate"]) === 5)
            {
                $timeArr = [];
                for($i=1; $i<=5; $i++)
                {
                    $addTime = $_SESSION["lastCommentDate"][count($_SESSION["lastCommentDate"]) - $i];
                    array_push($timeArr, $addTime);
                };
            }
            if(isset($timeArr)) $this->canBlockCommentForUser($timeArr);
            
            $response = (object) array("add"=>true, "ban"=>false);
            echo json_encode($response);
        }
    }
?>