<?php

    session_start();
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/propertyDB.php");

    class UserBan extends Connect
    {

        // sprawdzamy czy ban się skończył
        public function banIsOver()
        {
            $connect = $this->createConnect();
            $query = "SELECT canComment, banTime FROM bans WHERE user_id = '".$_SESSION["user_id"]."'";

            $result = $connect->query($query);
            $rows = $result->fetch_row();

            $banIsOver = false;
            if(!$rows[0])
            {
                $banTime =  strtotime($rows[1]);
                $currentTime = new DateTime("", new DateTimeZone("Europe/Warsaw"));

                $currentTime = strtotime($currentTime->format("Y-m-d H:i:s"));
                if($currentTime > $banTime)
                {
                    $query = "UPDATE bans SET canComment = 1 WHERE user_id = '".$_SESSION["user_id"]."'";
                    $connect->query($query);

                    $banIsOver = true;
                }
            };

            $connect->close();

            $res = (object) array("ban" => $banIsOver);
            return json_encode($res);
        }
    }

    if(isset($_GET["ban"]))
    {
        $isBan = new UserBan();
        echo $isBan->banIsOver();
    }
?>