<?php

    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/authorize.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/post/php/checkFile.php");

    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/checkValue.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/checkValue.php");

    class EditPost extends CheckFile
    {

        //sprawdzamy czy podany użytkownik ma uprawnienia do modyfikacji podanego postu i przechodzimy do walidacji plików
        function __construct(array | null $files = null, array | null $postPhotos = null, string $newPostValue = "")
        {

            $can = new Authorize();
            $can->modifyPost($_SESSION["user_id"], $_SESSION["post_id"]);
            $data = $this->checkCountOfSaveFiles($_SESSION["post_id"], $files, $postPhotos);

            $data === null?
            $this->replacePostValues(null, null, null, $_SESSION["post_id"], $newPostValue):
            $this->replacePostValues($data[0], $data[1], $data[2], $_SESSION["post_id"], $newPostValue);
        }

        //aktualizujemy wartości naszego postu
        private function replacePostValues(array | null $photoDirArr, array | null $deletePhotos, array | null $files, int $postId, string $newPostValue = "")
        {

            if($deletePhotos !== null)
            {
                foreach($deletePhotos as $e)
                {
                    unlink($_SERVER["DOCUMENT_ROOT"]."/forum/photos/".$e);

                    $key = array_search($e, $photoDirArr);
                    unset($photoDirArr[$key]);
                }
            }

            if($files !== null)
            {
                $this->saveFiles($files["name"], $files["tmp_name"]);

                foreach($_SESSION["files_".$_SESSION["user_login"]] as $a)
                {
                    array_push($photoDirArr, $a);
                };

                unset($_SESSION["files_".$_SESSION["user_login"]]);
            }

            $connect = $this->createConnect();

            $newDir = null;
            if($photoDirArr !== null)
            {
                $newDir = implode(", ", $photoDirArr);
            }
            
            if($newPostValue !== "")
            {
                $newDir !== null?
                $query = "UPDATE users_posts SET photo_dir = '$newDir', post_value = '$newPostValue' WHERE id = $postId":
                $query = "UPDATE users_posts SET post_value = '$newPostValue' WHERE id = $postId";
                
            }
            else if($photoDirArr !== null)
            {
                $query = "UPDATE users_posts SET photo_dir = '$newDir' WHERE id = $postId";
            }

            $connect->query($query);
            $connect->close();
        }
    }

    //sprawdzamy czu zostały wysłane zdjęcia
    if(isset($_FILES["file"]))
    {
       if(!authorize($_SESSION["user_login"])) return;
       $count = count($_FILES["file"]);

       //sprawdzamy czy została także wysłana nowa wartosć postu
       if(isset($_POST["newPostValue"]))
       {
           if(emptySpace($_POST["newPostValue"]))
           {
               echo "err_space";
               die;
           }

           isset($_POST["postPhotos"])?
           $editPost = new EditPost($_FILES["file"], $_POST["postPhotos"], $_POST["newPostValue"]): 
           $editPost = new EditPost($_FILES["file"], null, $_POST["newPostValue"]);
           return;
       }

       isset($_POST["postPhotos"])? $editPost = new EditPost($_FILES["file"], $_POST["postPhotos"]): $editPost = new EditPost($_FILES["file"]);
    }
    //w przypadku gdy nie zostały wysłane żadne zdjęcia sprawdzamy czy została wysłana nowa wartość postu
    else if($_POST["newPostValue"])
    {
        $edit = new EditPost(null, null, $_POST["newPostValue"][0]);
    }
?>