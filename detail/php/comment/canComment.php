<?php

    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/propertyDB.php");

    class CanComment extends Connect
    {

        //jeśli podana osoba jest zalogowana wyświetlamy jej panel umożliwiający dodawanie komentarzy
        public function canComment()
        {
            $connect = $this->createConnect();

            $query = "SELECT canComment, banTime FROM bans WHERE user_id = '".$_SESSION["user_id"]."'";
            $res = $connect->query($query);
            
            $row = $res->fetch_row();
            $canComm = $row[0];

            $currentTime = new DateTime('', new DateTimeZone("Europe/Warsaw"));
            $currentTime = strtotime($currentTime->format("Y:m:d h:i:s"));

            $time = strtotime($row[1]);

            $flag = false;
            if($currentTime > $time)
            {
                $flag = true;

                $query = "UPDATE bans SET canComment = 1, banTime = NULL WHERE user_id = '".$_SESSION["user_id"]."'";
                $connect->query($query);
            }
            else if($canComm)
            {
                $flag = true;
            };

            $connect->close();

            if(isset($_SESSION["user_login"]) && $_SESSION["res"] && $canComm && $flag)
            {
                unset($_SESSION["res"]);

                echo "<form>
                <textarea id='addComment' cols='30' rows='10'></textarea>
                <button id='add_comm' type='submit'>Dodaj komentarz</button>
                </form>";
            };
        }
    };

    if(isset($_SESSION["user_id"]))
    {
        $can = new CanComment();
        $can->canComment();
    };
    
?>