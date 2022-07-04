<?php

    session_start();
    require_once($_SERVER["DOCUMENT_ROOT"]."./forum/authorize.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."./forum/propertyDB.php");

    class CheckProfilFile extends Connect
    {
        private CONST profil_photo_settings = ["max_size" => 1000000, "type" => ["image/png", "image/jpeg", "image/jpg", "image/gif"], "src" => "../../profil_photos/"];

        function __construct($photo)
        {
            $this->checkPhoto($photo);
        }

        // sprawdzamy czy przesłane zdjęcia spełniają nasze kryteria
        private function checkPhoto($photo)
        {
            try
            {
                $res = array_search($photo["type"], self::profil_photo_settings["type"]);
               if( gettype($res) !== "integer")
               {
                   throw new Error("wrong file type");
               };

               if($photo["size"] < 1 || $photo["size"] > self::profil_photo_settings["max_size"])
               {
                    throw new Error("wrong file size");
               };

               $this->changeProfilPhoto($photo);
            }
            catch(Exception $e)
            {
                echo $e;
                die;
            }
        }

        // tworzymy nazwe dla zdjęcia
        private function newPhotoName()
        {
            
            function drawName()
            {
                $task = "";
                for($i=0; $i<25; $i++)
                {
                    $addDigit = rand(1, 4);

                    $letter = chr(rand(97, 122));
                    $task .= $letter;

                    if($addDigit > 3)
                    {
                        $digit = rand(0, 9);
                        $task .= $digit;

                        $i++;
                    }
                };

                return $task;
            }

            return drawName();
        }

        // zmieniamy zdjęcie profilowe użytkownika
        private function changeProfilPhoto($photo)
        {
            $to = self::profil_photo_settings["src"].$photo["name"];
            $from = $photo["tmp_name"];

            $userId = $_SESSION["user_id"];

            $connect = $this->createConnect();

            if(move_uploaded_file($from, $to))
            {
                do
                {
                    $newPhotoName = $this->newPhotoName().$photo["name"];
                    $query = "SELECT COUNT(photo_profil) FROM users WHERE id='$userId' AND photo_profil = ?";

                    $prepera = $connect->prepare($query);
                    $prepera->bind_param("s", $newPhotoName);

                    $prepera->bind_result($photo_profil);
                    $prepera->execute();

                    $prepera->fetch();
                    $prepera->store_result();

                    $res = $photo_profil;
                }
                while($res > 0);

                $prepera->close();
                
                $query = "UPDATE users SET photo_profil = ? WHERE id = '$userId'";
                $prepera = $connect->prepare($query);

                $prepera->bind_param("s", $newPhotoName);
                $prepera->execute();

                rename($to, self::profil_photo_settings["src"].$newPhotoName);
                $prepera->close();
            };

            $connect->close();
            $response = (object) array("change" => true);

            echo json_encode($response);
        }
    }

    if(isset($_FILES))
    {
        if(!authorize($_SESSION["user_id"])) die;
        $photo = $_FILES["photo"];

        $check = new CheckProfilFile($photo);
    }

?>