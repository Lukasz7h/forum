<?php

    session_start();
    require_once($_SERVER["DOCUMENT_ROOT"]."/forum/propertyDB.php");
    require_once("../php/getDir.php");

    class Save extends Connect
    {

        //pobieramy nazwy plików
        private function getFileDir()
        {
            $dir = getDir();
            return $dir !== 0? implode(", ", $dir): NULL;
        }
        
        //zapisujemy post w bazie danych
        function savePost($topic, $post_values)
        {
            $connect = $this->createConnect();
            $file_dir = $this->getFileDir();

            $query = "INSERT INTO users_posts(topic, post_value, photo_dir, user_id) VALUES(?, ?, ?, ?)";
            $prepare_query = $connect->prepare($query);

            $prepare_query->bind_param("ssss", $topic, $post_values, $file_dir, $_SESSION["user_id"]);
            $prepare_query->execute();

            $prepare_query->close();
            $connect->close();

            echo "done";
        }
    }
?>