<?php

    session_start();

    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/propertyDB.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/clearHTML.php");

    class Month extends Connect
    {
        //ustalamy który miesiąc został wybrany
        private function chooseMonth($month)
        {
            $count = 0;
            switch($month)
            {
                case "styczeń":
                    $count = '01';
                break;
                case "luty":
                    $count = '02';
                break;
                case "marzec":
                    $count = '03';
                break;
                case "kwiecień":
                    $count = '04';
                break;
                case "maj":
                    $count = '05';
                break;
                case "czerwiec":
                    $count = '06';
                break;
                case "lipiec":
                    $count = '07';
                break;
                case "sierpień":
                    $count = '08';
                break;
                case "wrzesień":
                    $count ='09';
                break;
                case "październik":
                    $count = '10';
                break;
                case "listopad":
                    $count = '11';
                break;
                case "grudzień":
                    $count = '12';
                break;
            }

            return $count;
        }

        //jeśli istnieje zmienna GET zawierająca informacje o aktualnej stronie i nie jest ona równa zeru to przypisujemy aktualną stronę do zmiennej page ale jeśli nie istnieje zmienna GET lub istnieje lecz jest równa zeru wtedy przypisujemy do zmiennej wartość 1 co świadczy o tym że użytkownik jest na pierwszej stronie
        private function getPage()
        {
            $page = isset($_GET["page"])? $_GET["page"]: 1;
            $page = intval($page);

            $page === 0? $page = 1: $page = $page;
            return $page;
        }

        //wyszukujemy wyniki dla podanego miesiąca
        public function getMonth(string $month, object $queryData = null, bool $lib = false)
        {
            $page = $this->getPage();
            $createConnect = $this->createConnect();

            $limit = 12;
            $skip = $page * $limit - $limit;

            if(!$queryData)
            {
                $thatMonth = $this->chooseMonth($month);
                $query = "SELECT COUNT(id) FROM users_posts WHERE MONTH(post_date) = $thatMonth";

                $res = $createConnect->query($query);
            }
            else
            {
                $time = $queryData->period;
                $many = $queryData->many;
                
                if($many === 0)
                {
                    $query = "SELECT COUNT(id) FROM solved";
                }
                else
                {
                    $date = true;
                    switch($time)
                    {
                        case "year":
                            $query = "SELECT COUNT(id) FROM solved WHERE post_date > DATE(NOW()-INTERVAL $many YEAR)";
                        break;
                        case "month":
                            $query = "SELECT COUNT(id) FROM solved WHERE post_date > DATE(NOW()-INTERVAL $many MONTH)";
                        break;
                        case "day":
                            $query = "SELECT COUNT(id) FROM solved WHERE post_date > DATE(NOW()-INTERVAL $many DAY)";
                        break;
                    };
                };

                if($queryData->search !== null) 
                {
                    isset($date)?
                    $query .= " AND (topic LIKE '%".$queryData->search."%' OR post_value LIKE '%".$queryData->search."%')":
                    $query .= " WHERE topic LIKE '%".$queryData->search."%' OR post_value LIKE '%".$queryData->search."%'";
                };

                $res = $createConnect->query($query);
            };

            if($res->num_rows > 0)
            {
                while($row = $res->fetch_row())
                {
                    $count = $row[0];
                };
            };

            $count = $count / 12;
            $count = ceil($count);

            $query = $queryData === null?
            $query = "SELECT id, topic, post_value, post_date FROM users_posts WHERE MONTH(post_date) = $thatMonth":
            $queryData->query;

            if(isset($queryData) && $queryData->search !== null)
            {
                isset($date)?
                $query .= " AND (topic LIKE '%".$queryData->search."%' OR post_value LIKE '%".$queryData->search."%')":
                $query .= " WHERE topic LIKE '%".$queryData->search."%' OR post_value LIKE '%".$queryData->search."%'";
            };

            $query .= " LIMIT $skip, $limit";
            $res = $createConnect->query($query);

            //po znalezieniu wyników zostają one wypisane
            while($row = $res->fetch_row())
            {
                echo "<div class='post' data-post='".$row[0]."'>
                    <span>".clearHTML($row[1])."</span>
                    <span>".substr(clearHTML($row[2]),0 ,200)."</span>
                    <span>".$row[3]."</span>
                </div>";
            };
            $link_page = "<p>";

            // tworzymy link do wszystkich stron
            for($i=1; $i<=$count; $i++)
            {
                $i === $page?
                $link_page .=" $i ":
                [
                    $lib?
                    $link_page .="<a href='http://".$_SERVER["SERVER_NAME"]."/forum/resolved/index.php?&page=$i'> $i </a>":
                    $link_page .="<a href='http://".$_SERVER["SERVER_NAME"]."/forum/year/month.php?month=$month&page=$i'> $i </a>"
                ];
            };

            $link_page .= "</p>";
            
            if($count > 1){
                echo $link_page;
            }
            else if($count < 1 && !$lib){
                echo "<h3>Pusto</h3>
                <p>Jeżeli szukałeś konktretnego postu to poszukaj też w bibliotece gdzie znajdują się wszystkie rozwiązane problemy.</p>";
            }
            else if($count < 1 && $lib)
            {
                echo "<h3>Brak wyników!</h3>";
            };
            $createConnect->close();
        }
    }
?>