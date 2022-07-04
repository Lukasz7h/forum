<?php

    session_start();

    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/propertyDB.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/clearHTML.php");

    class GetPost extends Connect
    {
        
        public function getResponse(int $postId)
        {
            return $this->getPost($postId);
        }

        private function updateCommCount(int $post_id, $connect)
        {
            $query = "SELECT id FROM comments WHERE id_post = $post_id";
            $res = $connect->query($query);

            $amountOfComm = $res->num_rows;

            $query = "UPDATE users_posts SET comm_amount = $amountOfComm WHERE id = $post_id";
            $connect->query($query);
        }

        //pobieramy dane postu o podanym id
        protected function getPost(int $postId, bool $flag = true)
        {
            $connect = $this->createConnect();

            $flag?
            $query = "SELECT users_posts.topic, users_posts.post_value, users_posts.photo_dir, users_posts.post_date, users_posts.user_id, users.login, users_posts.id FROM users_posts INNER JOIN(users) ON users.id = users_posts.user_id WHERE users_posts.id = $postId LIMIT 1":
            $query = "SELECT solved.topic, solved.post_value, solved.photo_dir, solved.post_date, solved.user_id, users.login, solved.id FROM solved INNER JOIN(users) ON users.id = solved.user_id WHERE solved.id = $postId LIMIT 1";

            $_SESSION["post_id"] = $postId;
            
            $res = $connect->query($query);
            if($res->num_rows === 1)
            {

                echo "<div id='post' data-post='".$postId."'>";
                while($row = $res->fetch_row())
                {

                    echo "<div><h3>".$row[5]."</h3><h3>".clearHTML($row[0])."</h3><h3>".$row[3]."</h3></div>";
                    echo "<p id='post_value'>".clearHTML($row[1])."</p>";
                    $user_id = $row[4];

                    if(strlen($row[2])>0)
                    {
                        $dir = explode(", ", $row[2]);

                        foreach($dir as $e)
                        {
                            $img = @base64_encode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/forum/photos/".$e));
                            $img = strval($img);
                            echo "<img src='data: image/png; base64,$img'>";
                        };
                    };
                };

                if(isset($_SESSION["user_id"]) && $_SESSION["user_id"] === $user_id && $flag)
                {
                    $this->updateCommCount($_SESSION["post_id"], $connect);
                    echo "<button id='edit_post'>Edytuj post</button><button id='delete_post'>Usuń post</button>";
                };
                echo "</div>";

                $connect->close();
                return true;
            }
            else
            {
                $connect->close();
                $_SESSION["post_id"] = 0;

                header("Location: http://".$_SERVER["HTTP_HOST"]."/forum/main/");
                return false;
            };
        }
    }

    //jeśli istnieje zmienna GET sprawdzamy pobieramy post o id podanym w zmiennej
    if(isset($_GET["post"]))
    {
        $post = intval($_GET["post"]);

        if(is_int($post) && $post !== 0)
        {
            $getPost = new GetPost();
            $_SESSION["res"] = $getPost->getResponse($post);
        };
    };
?>