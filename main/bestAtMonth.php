<?php

    include_once($_SERVER["DOCUMENT_ROOT"]."../forum/propertyDB.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/clearHTML.php");

    if(!class_exists("BestAtMonth"))
    {
        class BestAtMonth extends Connect
        {
            function __construct(string  $month)
            {
                $this->getForMonth($month);
            }
    
            // zwracamy posty dla odpowiedniej daty
            private function getForMonth(string  $month)
            {
                $year = new DateTime("", new DateTimeZone("Europe/Warsaw"));
                $year = $year->format("Y");

                $connect = $this->createConnect();
                $query = "SELECT user_id, scores FROM bestofmonth WHERE MONTH(thatDate) = '$month' AND YEAR(thatDate) = '$year'";

                $res = $connect->query($query);
                if($res->num_rows > 0)
                {
                    $row = $res->fetch_row();

                    $user_id = $row[0];
                    $scores = $row[1];

                    $query = "SELECT login, photo_profil FROM users WHERE id = '$user_id'";
                    $res = $connect->query($query);

                    if($res->num_rows > 0)
                    {
                        $row = $res->fetch_row();

                        $login = clearHTML($row[0]);
                        $photo = $row[1];

                        if(!$photo) $photo = "user.png";
                        $content = base64_encode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/forum/profil_photos/".$photo));
                        
                        echo "<img src='data:image/png; base64, $content'>";
                        echo "<p>$login - $scores</p>";
                    };
                };
            }
        };  
    };
    $best = new BestAtMonth($month);
?>