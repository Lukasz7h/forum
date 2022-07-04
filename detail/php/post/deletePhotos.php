<?php
    session_start();
    require_once($_SERVER['DOCUMENT_ROOT']."../forum/authorize.php");

    class DeletePhotos extends Authorize
    {

        //jeśli podany użytkownik jest właścicielem postu to przechodzimu do jego usunięcia
        public function deletePhotos(array $deletePhotos)
        {
            $this->modifyPost($_SESSION["user_id"], $_SESSION["post_id"]);

            $connect = $this->createConnect();
            $query = "SELECT photo_dir FROM users_posts WHERE id=".$_SESSION["post_id"]."";

            $res = $connect->query($query);
            while($row = $res->fetch_row())
            {
                $photo_dir = $row[0];
            }

            $photo_dir = explode(', ', $photo_dir);

            foreach($deletePhotos as $e)
            {
                if(empty($e)) continue;
                unlink($_SERVER["DOCUMENT_ROOT"]."/forum/photos/".$photo_dir[$e]);

                $key = array_search($photo_dir[$e], $photo_dir);
                print_r($photo_dir[$key]);
                unset($photo_dir[$key]);
            }

            $newPhotoDir = implode(', ',$photo_dir);

            $query = "UPDATE users_posts SET photo_dir = '$newPhotoDir' WHERE id=".$_SESSION["post_id"]."";
            $connect->query($query);

            $connect->close();
        }
    }

    //sprawdzamy czy zostały przesłane przez użytkownika które zdjęcia w poście usunąć a następnie sprawdzamy czy użytkownik wysyłający te informacje jest zalogowany
    if(isset($_POST["deletePhotos"]))
    {
        if(!authorize($_SESSION["user_login"]) || intval($_SESSION["post_id"] === 0)) return;
        $deleteArr = [];

        foreach($_POST["deletePhotos"] as $photo)
        {
            $photo = explode(",", $photo);
            foreach($photo as $e)
            {
                $len = strlen($e);
                $word = "";

                for($i=0; $i<$len; $i++)
                {
                    $word .= $e[$i];
                    if($e[$i] === "/") $word = "";
                };

                array_push($deleteArr, $word);
            };
        };

        $deletePhotos = new DeletePhotos();
        $deletePhotos->deletePhotos($deleteArr);
    };
?>