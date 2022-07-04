<?php

    session_start();
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/propertyDB.php");

    class CheckData extends Connect
    {

        function __construct(object $profilData)
        {
            $this->issetThatProfil($profilData);
        }

        // usuwamy zdjęcia użytkownika
        private function removePhotoForProfil(string $photo, string $dir)
        {
            $photos = explode(", ", $photo);
            foreach($photos as $photo)
            {
                unlink($_SERVER["DOCUMENT_ROOT"]."/forum".$dir."/".$photo);
            };
        }
    
        // usuwamy profil użytkownika
        private function removeProfil()
        {
            $connect = $this->createConnect();
            $id = $_SESSION["user_id"];

            $query = "SELECT photo_profil FROM users WHERE id = '$id'";
            $result = $connect->query($query);

            $rows = $result->fetch_row();
            $photo = $rows[0];

            if($photo) $this->removePhotoForProfil($photo, "/profil_photos");

            $query = "SELECT photo_dir FROM users_posts WHERE user_id = '$id' AND photo_dir IS NOT NULL";
            $result = $connect->query($query);

            if($result->num_rows > 0)
            {
                while($row = $result->fetch_row())
                {
                    $photo_dir = $row[0];
                    $this->removePhotoForProfil($photo_dir, "/photos");
                };
            };

            $query = "DELETE FROM verify_emails WHERE user_id = $id";
            $connect->query($query);

            $query = "DELETE FROM users_posts WHERE user_id = '$id'";
            $connect->query($query);

            $query = "DELETE FROM users_key WHERE id_user = '$id'";
            $connect->query($query);

            $query = "UPDATE users SET login = NULL, password = NULL, email = '', photo_profil = NULL WHERE id = '$id'";
            $connect->query($query);

            $query = "DELETE FROM scores WHERE id_user = '$id'";
            $connect->query($query);

            $query = "DELETE FROM reset_password WHERE user_id = '$id'";
            $connect->query($query);

            $query = "DELETE FROM reset_password WHERE user_id = '$id'";
            $connect->query($query);

            $query = "DELETE FROM bans WHERE user_id = '$id'";
            $connect->query($query);

            $_SESSION = array();
            setcookie("user_key", "", time()-3600, "/", "");
            
            session_destroy();

            echo json_encode((object)["remove" => true]);
        }

        // sprawdzamy czy istnieje profil o podanych danych
        private function issetThatProfil(object $profil)
        {
            $connect = $this->createConnect();
            $query = "SELECT id FROM users WHERE login = ? AND password = ?";

            $salt = "H98h^&^ffjgRUR(*7798TDFgd98assa46)&*^(gHJt&^87^%(wd4ag(T*Rd8AL9(&awwdF8F8F";
            $hash_password = hash("SHA512", $profil->password.$salt);

            $prepare = $connect->prepare($query);
            $prepare->bind_param("ss", $profil->login, $hash_password);

            $prepare->bind_result($id);
            $prepare->execute();

            $prepare->fetch();
            if($id === $_SESSION["user_id"]) $this->removeProfil();
        }
    };

    if(isset($_POST["profilData"]))
    {
        $check = new CheckData(json_decode($_POST["profilData"]));
    };
?>