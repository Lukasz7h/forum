<?php
    
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/propertyDB.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/clearHTML.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/authorize.php");

    class Comments extends Connect
    {
        function __construct(int $post_id = 0, bool $flag = true)
        {
            if($post_id !== 0) $this->getAllComments($post_id, $flag);
        }

        // pobieramy range użytkownika
        private function getRank($res, int $rankScores)
        {
            $thatRank = "test";

            while($row = $res->fetch_row())
            {
                if($row[0] <= $rankScores)
                {
                    $thatRank = $row[1];
                }
            }

            return $thatRank;
        }

        //zostają pobrane wartości komentarzy dla aktualnie wyświetlanego postu i id użytkownika który utworzył post a następnie wyświetlamy użytkownikowi odpowiedni wartości
        private function getAllComments(int $post_id, bool $flag = true)
        {
            $connect = $this->createConnect();
            $flag?
            $query = "SELECT comments.id, comments.id_user, comments.login_user, comments.comment_value, comments.is_solution, comments.is_agree, comments.is_not_agree, comments.comment_date, users_posts.user_id, users.photo_profil, scores.scores FROM users_posts INNER JOIN(comments) INNER JOIN(users) INNER JOIN(scores) WHERE comments.id_post = $post_id AND users_posts.id = $post_id AND users.id = comments.id_user AND scores.id_user = comments.id_user":

            $query = "SELECT comments.id, comments.id_user, comments.login_user, comments.comment_value, comments.is_solution, comments.is_agree, comments.is_not_agree, comments.comment_date, solved.user_id, users.photo_profil, scores.scores FROM solved INNER JOIN(comments) INNER JOIN(users) INNER JOIN(scores) WHERE comments.id_post = $post_id AND solved.id = $post_id AND users.id = comments.id_user AND scores.id_user = comments.id_user";

            $res = $connect->query($query);

            if($res->num_rows > 0)
            {

                while($row = $res->fetch_row())
                {
                    $query = "SELECT scores, rank FROM levels";
                    $ranks = $connect->query($query);
                    $rank = $this->getRank($ranks, $row[10]);

                    $img = empty($row[9])? base64_encode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/forum/profil_photos/user.png")): base64_encode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/forum/profil_photos/".$row[9]));
                    $img = strval($img);

                    echo "<div class='comment'>
                    <span> ".clearHTML($row[2])."</span>
                    <span> ".$row[7]."</span>
                    <p class='scores'><span class='count'>".$row[10]."</span> - <span class='rank'>".$rank."</span></p>
                    <img src='data:image/png; base64,$img'>
                    <p data-id='".$row[0]."' class='content_comm'>".clearHTML($row[3])."</p>";

                    if(isset($_SESSION["user_id"]) && $_SESSION["user_id"] === $row[1] && $flag)
                    {
                        echo "<button class='edit_comm'>Edytuj</button><button class='delete_comm'>Usuń</button>";
                    };

                    if(isset($_SESSION["user_id"]) && $_SESSION["user_id"] === $row[8] && $_SESSION["user_id"] !== $row[1] && $flag)
                    {
                        echo "<button class='answer'>Odpowiedź</button>";
                    };

                    if(isset($_SESSION["user_id"]) && $_SESSION["user_id"] !== $row[1] && $flag)
                    {
                        echo "<button class='agree'>Zgadzam się <span>".$row[5]."</span></button><button class='not_agree'>Nie zgadzam się <span>".$row[6]."</span></button>";
                    }
                    else if(isset($_SESSION["user_id"]) && $_SESSION["user_id"] === $row[1] || isset($_SESSION["user_id"]) && $_SESSION["user_id"] !== $row[1] && !$flag)
                    {
                        echo "<p class='review'>Zgadza się <span class='agree_count'>".$row[5]."</span> Nie zgadza się <span class='not_agree_count'>".$row[6]."</span></p>";
                    };

                    echo "</div>";
                };
            };
        }

        //funkcja ta zwraca aktualne komentarze dla aktualnie wyświetlanego posta
        public function compareComments(int $post_id)
        {
            $connect = $this->createConnect();

            $query = "SELECT COUNT(id) FROM users_posts WHERE id = $post_id";
            $res = $connect->query($query);

            if($res->fetch_row()[0] == 0)
            {
                $response = (object)[];
                $response->isset = false;

                echo json_encode($response);
                die;
            };

            $query = "SELECT comments.id, comments.login_user, comments.comment_value, comments.is_solution, comments.is_agree, comments.is_not_agree, comments.comment_date, comments.id_user, users_posts.user_id, users.photo_profil, scores.scores FROM comments INNER JOIN(users_posts) INNER JOIN(users) INNER JOIN(scores) WHERE comments.id_post = $post_id AND users_posts.id = $post_id AND users.id = comments.id_user AND scores.id_user = comments.id_user";

            $res = $connect->query($query);
            if($res->num_rows > 0)
            {
                $arr = [];
                while($row = $res->fetch_row())
                {
                    $query = "SELECT scores, rank FROM levels";
                    $ranks = $connect->query($query);
                    $rank = $this->getRank($ranks, $row[10]);

                    $obj = (object)[];
                    $obj->id = $row[0];

                    $obj->login = $row[1];
                    $obj->value = $row[2];

                    $obj->solution = $row[3];
                    $obj->is_agree = $row[4];

                    $obj->not_agree = $row[5];
                    $obj->date = $row[6];

                    $that_user = null;
                    $obj->canReview = false;
                    if(isset($_SESSION["user_id"]))
                    {
                        $obj->canReview = true;
                        $that_user = $_SESSION["user_id"] === $row[7];
                    };

                    $obj->id_user = $that_user;
                    $post_author = null;

                    if(isset($_SESSION["user_id"])) $post_author =  $_SESSION["user_id"] === $row[8];

                    $img = empty($row[9])?
                    base64_encode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/forum/profil_photos/user.png")):
                    base64_encode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/forum/profil_photos/".$row[9]));
                    $img = strval($img);

                    $obj->photo = $img;
                    $obj->data = $row[9];

                    $obj->author = $post_author;

                    $obj->scores = $row[10];
                    $obj->rank = $rank;

                    array_push($arr, $obj);
                };

                echo json_encode($arr);
            }
            else{
                $query = "SELECT id FROM solved WHERE id = $post_id";
                $res = $connect->query($query);

                if($res->num_rows > 0)
                {
                    $obj = (object)[];

                    $obj->answer = true;
                    echo json_encode($obj);

                    $connect->close();
                    die;
                };  
            };

            $connect->close();
        }
    }

    if(isset($_SESSION["res"]) && $_SESSION["res"] && !isset($_GET["id"]))
    {
        $comments = new Comments($_SESSION['post_id']);
    };

    if(isset($_POST["post_id"]))
    {
        session_start();
        $comments = new Comments();
        $comments->compareComments($_SESSION["post_id"]);
    };
?>