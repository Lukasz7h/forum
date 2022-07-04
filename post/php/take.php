<?php

    require_once("../php/checkFile.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/authorize.php");

    class Init extends CheckFile
    {
        public function __construct($countFiles, $files_type, $files_size, $files_name, $files_src)
        {
            $this->howMuch($countFiles);
            $this->checkType($files_type);

            $this->checkSize($files_size);
            $this->saveFiles($files_name, $files_src);
        }
    }

    // jeśli zostały przesłane pliki sprawdzamy je
    if(isset($_FILES["myFiles"]))
    {
        if(!authorize($_SESSION["user_login"])) return;
        $countFiles = count($_FILES["myFiles"]["name"]);

        $files_type = getFileData("type");
        $files_size = getFileData("size");

        $files_name = getFileData("name");
        $files_src = getFileData("tmp_name");

        $init = new Init($countFiles, $files_type, $files_size, $files_name, $files_src);
    }
    else
    {
        echo "ok";
    };

    //pobieramy informacje o przesłanych plikach
    function getFileData($data)
    {
        $arr = [];
        foreach($_FILES["myFiles"]["$data"] as $file)
        {
            array_push($arr, $file);
        };

        return $arr;
    }
    
?>