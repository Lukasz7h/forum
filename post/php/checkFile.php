<?php

    session_start();
    require_once($_SERVER["DOCUMENT_ROOT"]."/forum/propertyDB.php");

    class CheckFile extends Connect
    {
        private CONST FILE_TYPES = ["image/png", "image/jpg", "image/jpeg", "image/gif"]; //dozwolone typy plików
        private CONST MAX_FILE_SIZE = 1048576; //maksymalny rozmiar to 1MB

        private CONST MAX_FILES_COUNT = 6;

        //sprawdzamy czy ilosć zdjęć nie przekracza maksymalnej wartości
        protected function howMuch(int $files_count)
        {
            if($files_count > self::MAX_FILES_COUNT)
            {
                echo "err_count";
                exit;
            }
        }

        //sprawdzamy czy wszystkie pliki są zdjęciami
        protected function checkType($photos)
        {
            foreach($photos as $photo_type)
            {

                $flag = false;

                for($i=0; $i<count(self::FILE_TYPES); $i++)
                {
                    if($photo_type === self::FILE_TYPES[$i])
                    {
                        $flag = true;
                    }
                }

                if(!$flag)
                {
                    echo "err_type";
                    exit;
                }
            }
            return true;
        }

        //sprawdzamy czy rozmiar zdjęć przekracza maksymalną dozwoloną wartość
        protected function checkSize($photos)
        {
            foreach($photos as $photo_size)
            {

                if($photo_size < 1 || $photo_size > self::MAX_FILE_SIZE)
                {
                    echo "err_size";
                    exit;
                }
            }
        }

        //zwracamy liczbe postów
        private function numPost()
        {
            $createConnect = $this->createConnect();
            $query = "SELECT COUNT(id) FROM users_posts";

            $res = $createConnect->query($query);

            $res = $res->fetch_row();
            return $res[0];
        }

        //zapiujemy zdjęcia
        protected function saveFiles($files_name, $files_src)
        {

            $rand = function ($str = "")
            {
                for($i=0; $i<35; $i++)
                {
                    $str .= chr(rand(97, 122));
                }
                return $str;
            };
            
            $files_dir = [];
            for($i=0; $i<count($files_name); $i++)
            {
                $str = $rand();

                move_uploaded_file($files_src[$i], $_SERVER["DOCUMENT_ROOT"]."/forum/photos/".$files_name[$i]);
                $newName = $this->numPost();

                rename($_SERVER["DOCUMENT_ROOT"]."/forum/photos/".$files_name[$i], $_SERVER["DOCUMENT_ROOT"]."/forum/photos/".$newName.$str.$files_name[$i]);
                array_push($files_dir, $newName.$str.$files_name[$i]);
            }

            $_SESSION["files_".$_SESSION["user_login"]] = $files_dir;
            echo "ok";
        }

        //zostaje sprawdzona ilość wysłanych i zapisanych plików jeśli ilość plików zapisanych i do zapisanie nie przekracza odpowiedniej wartości sprawdzamy jeszcze typ plików i rozmiar jeśli wszystko jest w porządku to modyfikujemy nasz post
        protected function checkCountOfSaveFiles(int $postId, array | null $files, array | null $postPhotos)
        {
            if($files === null && $postPhotos === null) return;

            $createConnect = $this->createConnect();
            $query = "SELECT photo_dir FROM users_posts WHERE id=$postId";

            $res = $createConnect->query($query);

            while($row = $res->fetch_row())
            {
                strlen($row[0]) > 0? $photoDirArr = explode(", ", $row[0]): $photoDirArr = [];
            }

            $createConnect->close();

            $saveFilesCount = count($photoDirArr);
            $sendFilesCount = count($files["name"]);

            if($postPhotos !== null)
            {
                $deletePhotos = [];
                foreach($postPhotos as $photo)
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
                        }

                        array_push($deletePhotos, $word);
                    }
                }
                $deletePhotosCount = count($deletePhotos);

                $this->howMuch($saveFilesCount - $deletePhotosCount + $sendFilesCount);
                $this->checkType($files["type"]);
                $this->checkSize($files["size"]);

                return[$photoDirArr, $deletePhotos, $files];
            }

            else
            {
                $this->howMuch($saveFilesCount + $sendFilesCount);
                return[$photoDirArr, null, $files];
            }
        }
    }
?>