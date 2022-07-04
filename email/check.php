<?php

    session_start();
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/propertyDB.php");

    if(!isset($_SESSION["user_id"]))
    {
        header("Location: http://".$_SERVER["HTTP_HOST"]."/forum/main");
        die;
    };

    class Check extends Connect
    {
        function __construct()
        {
            $this->isEmailToValid();
        }

        private function isEmailToValid()
        {
            $connect = $this->createConnect();

            $id = $_SESSION["user_id"];
            $query = "SELECT email FROM verify_emails WHERE user_id='$id'";

            $res = $connect->query($query);
            if($res->num_rows === 0)
            {
                header("Location: http://".$_SERVER["HTTP_HOST"]."/forum/main");
                die;
            };

            while($row = $res->fetch_row())
            {
                $email = $row[0];
                $id = $_SESSION["user_id"];

                $query = "DELETE FROM verify_emails WHERE user_id='$id'";
                $upd_query = "UPDATE users SET email=? WHERE id='$id'";
            };

            $prepare = $connect->prepare($upd_query);
            $prepare->bind_param("s", $email);

            $connect->query($query);
            $prepare->execute();

            $prepare->close();
            $connect->close();
        }
    }

    $check = new Check();
?>