<?php

    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/clearHTML.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/year/getThatMonth.php");

    class FindResolved
    {
        // zwracamy rozwiązane posty z odpowiedniego okresu czasu i z odpowiednią treścią
        function __construct(string $search = null, string $when = null, int $time = 0)
        {
            $_SESSION["solved_query_when"] = $when;
            $when = $when === null? new DateTime(): $when;
            $month = new Month();

            if(gettype($when) === "object") 
            {
                $when = $when->format("m");

                $query = "SELECT id, topic, post_value, post_date FROM solved";
                $queryData = (object)[];

                $queryData->period = "month";
                $queryData->many = 0;

                $queryData->query = $query;
                $queryData->search = null;

                echo $month->getMonth("", $queryData, true);
            }
            else
            {
                $_SESSION["solved_query_search"] = $search;
                $_SESSION["solved_query_time"] = $time;

                $query = $this->chooseQuery($when, $time);
                $queryData = (object)[];

                $queryData->period = $when;
                $queryData->many = $time;

                $queryData->query = $query;
                $queryData->search = $search;

                echo $month->getMonth("", $queryData, true);
            };
        }

        // wybieramy które pytanie zadamy do bazy danych
        function chooseQuery(string $when, int $time)
        {
            if($time === 0)
            {
                $query = "SELECT id, topic, post_value, post_date FROM solved";
            }
            else
            {
                switch($when)
                {
                    case "year":
                        $query = "SELECT id, topic, post_value, post_date FROM solved WHERE post_date > DATE(NOW() - INTERVAL $time YEAR)";
                    break;
                    case "month":
                        $query = "SELECT id, topic, post_value, post_date FROM solved WHERE post_date > DATE(NOW() - INTERVAL $time MONTH)";
                    break;
                    case "day":
                        $query = "SELECT id, topic, post_value, post_date FROM solved WHERE post_date > DATE(NOW() - INTERVAL $time DAY)";
                    break;
                };
            };

            return $query;
        }
    };

    if(isset($_POST["findData"]))
    {
        $sendData = json_decode($_POST["findData"]);
        $find = new FindResolved($sendData->inputSearch, $sendData->selectPeriod, intval($sendData->inputPeriod));
    }
    else if(isset($_GET["page"]) && isset($_SESSION["solved_query_search"]))
    {
        $find = new FindResolved($_SESSION["solved_query_search"], $_SESSION["solved_query_when"], $_SESSION["solved_query_time"]);
    }
    else
    {
        $find = new FindResolved();
    };
?>