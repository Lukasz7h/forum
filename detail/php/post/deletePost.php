<?php

    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/authorize.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/detail/php/post/deletePhotos.php");

    class DeletePost extends Authorize
    {

        function __construct()
        {

            $this->deletePost($_SESSION["user_id"], $_SESSION["post_id"]);
        }

        //jeśli użytkownik jest właścicielem postu to przechodzimy do jego usunięcia
        protected function deletePost(string $userID, int $postID)
        {
            $this->modifyPost($userID, $postID);

            $connect = $this->createConnect();
            $query = "SELECT photo_dir FROM users_posts WHERE id=$postID";
            $res = $connect->query($query);

            if($res->num_rows > 0)
            {
                while($row = $res->fetch_row())
                {
                    $photos = $row[0];
                    $photos = explode(", ", $photos);

                    $deletePhotos = new DeletePhotos();
                    $deletePhotos->deletePhotos($photos);
                }
            }

            $query = "DELETE FROM users_posts WHERE id=$postID";
            $connect->query($query);

            $query = "DELETE FROM comments WHERE id_post=$postID";
            $connect->query($query);

            if(isset($_SESSION["files_".$_SESSION["user_login"]]))
            {
                echo "racja";
            }
            $connect->close();
        }
    }

    //jeśli użytkownik który wysyła żądnie o usunięcie postu jest zalogowany przechodzimy do jego autoryzacji
    if(isset($_POST))
    {
        if(!authorize($_SESSION["user_login"])) return;
        $delete = new DeletePost();
    }
?>