<?php

    require_once($_SERVER["DOCUMENT_ROOT"]."/forum/propertyDB.php");

    class User extends Connect
    {

        function __construct()
        {
            echo "<div id='container'>";
            $this->writeHeader();
            $this->addEmail();
            echo "</div>";
        }

        // jeśli użytkownik nie dodal email dajemy mu taką możliwość
        private function addEmail()
        {
            $id = $_SESSION["user_id"];

            $connect = $this->createConnect();
            $query = "SELECT id FROM users WHERE id='$id' AND email IS NULL";
            
            $res = $connect->query($query);

            if($res->num_rows == 1)
            {
                echo "<div id='add_email'><input id='add_emailInp' data-input='email' type='text'><button id='add_emailButt'>Dodaj email</button></div>";
            };
        }

        // pokazujemy nagłówek w profilu użytkownika
        private function writeHeader()
        {
            if(isset($_SESSION["user_login"]))
            {
                $id = $_SESSION["user_id"];
                $connect = $this->createConnect();

                $query = "SELECT photo_profil FROM users WHERE id = '$id'";
                $res = $connect->query($query);

                $profil_profil = $res->fetch_row();

                echo "<h2>Twój profil</h2>";
                echo "<a href='../profil/removeProfil/'><button id='remove_profil'>Usuń profil</button></a>";
    
                echo "<div id='profil'><input type='file' style='opacity: 0.0; position: absolute; top: 0; left: 0; bottom: 0; right: 0; width: 100%; height:100%;'/><img src=''></div>";
                echo $this->getDataOfUser();
            };
        }

        // pobieramy dane o użytkowniku i wyświetlamy je w profilu użytkownika
        private function getDataOfUser()
        {
            $id = $_SESSION["user_id"];
            $connect = $this->createConnect();

            echo "<h2>Ranga:</h2>";
            $query = "SELECT scores FROM scores WHERE id_user = '$id'";
            $res = $connect->query($query);

            $scores = $res->fetch_row()[0];
            echo "<h4>Punkty: ".$scores."</h4>";

            $query = "SELECT rank FROM levels WHERE scores < $scores OR scores = $scores LIMIT 0, 1";
            $res = $connect->query($query);

            echo "<h4>Status: ".$res->fetch_row()[0]."</h4>";
            echo "<h2>Posty:</h2>";

            $query = "SELECT COUNT(id) FROM users_posts WHERE user_id='$id'";
            $res = $connect->query($query);

            $query = "SELECT COUNT(id) FROM solved WHERE user_id='$id'";
            $res1 = $connect->query($query);

            echo "<p> Liczba napisanych postów: ".$res->fetch_row()[0] + $res1->fetch_row()[0]."</p>";

            $query = "SELECT COUNT(id) FROM comments WHERE id_user='$id' AND is_solution = 1";
            $res = $connect->query($query);

            echo "<p> Liczba rozwiązanych postów: ".$res->fetch_row()[0]."</p>";
            echo "<h2>Komentarze:</h2>";

            $query = "SELECT COUNT(id) FROM comments WHERE id_user='$id'";
            $res = $connect->query($query);

            echo "<p>Napisane komentarze: ".$res->fetch_row()[0]."</p>";

            $query = "SELECT COUNT(id) FROM comments WHERE id_user='$id' AND is_agree = 1";
            $res = $connect->query($query);

            if($res)
            {
                $count = $res->fetch_row()[0];
                $a = $count && $count > 0? $count: 0;
            }
            else
            {
                $a = 0;
            };
            echo "<p>Ilość użytkowników którzy się z tobą zgadzają: ".$a."</p>";

            $connect = $this->createConnect();
            $query = "SELECT email FROM users WHERE id = '".$_SESSION["user_id"]."' AND email IS NOT NULL";

            $res = $connect->query($query);
            if($res->num_rows > 0) echo "<a href='./change_email' style='margin-top: 30px;'><button>Zmień email</button></a>";
            echo "<a href='./change_password/' style='margin-top: 30px;'><button>Zmień hasło</button></a>";
        }
    };

    if(isset($_SESSION["user_id"]))
    {
        $user = new User();
    }
    else
    {
        header("Location: http://".$_SERVER["HTTP_HOST"]."/forum/main");
    };
?>