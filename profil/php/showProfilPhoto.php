<?php

    session_start();
    require_once($_SERVER["DOCUMENT_ROOT"]."./forum/propertyDB.php");

    class ProfilPhoto extends Connect
    {
        function __construct(string $id)
        {
            $this->getProfilPhoto($id);
        }

        private function getProfilPhoto(string $id)
        {
            $connect = $this->createConnect();
            $query = "SELECT photo_profil FROM users WHERE id = '$id'";

            $result = $connect->query($query);
            $row = $result->fetch_row();

            $photo = $row[0];
            if(!$photo) $photo = "user.png";
            $content = base64_encode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/forum/profil_photos/".$photo));

            echo $content;
        }
    }

    if(isset($_SESSION["user_id"]))
    {
        $profilPhoto = new ProfilPhoto($_SESSION["user_id"]);
    }
?>