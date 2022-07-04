<?php
    // ustalamy tu która osoba zdobyła najwięcej punktów w danym miesiącu

    $host = "localhost";
    $name = "root";
    $password = "";
    $base = "forum";

    $connect = @mysqli_connect($host, $name, $password, $base)or die("Brak połącznia!");

    $date = new DateTime("", new DateTimeZone("Europe/Warsaw"));
    $year = $date->format("Y");

    $year = intval($year);

    $month = $date->format("m");
    $month = intval($month);

    if($month == 1)
    {
        $month = 12;
        $year = $year - 1;
    }
    else
    {
        $month = $month - 1;
        $month = $month < 10? "0".$month: strval($month);
    };
    $query = "SELECT id_user, is_agree, is_solution FROM comments WHERE is_agree = 1 OR is_solution = 1 AND MONTH(comment_date) = $month AND YEAR(comment_date) = $year";
    $res = @$connect->query($query);

    $users = [];

    if($res->num_rows > 0)
    {
        function addUser($id, $agree, $solution, $users)
        {
            $user = (object)array();
            $user->id = $id;

            $add = $agree * 20;
            if($solution) $add = $add + 70;

            $user->scores = $agree != 0? $add: $solution * 70;
            array_push($users, $user);
            return $users;
        };

        while($row = $res->fetch_row())
        {
            if(count($users) > 0)
            {
                $flag = false;
                foreach($users as $user)
                {
                    if($user->id == $row[0]) $flag = true;
                };

                if($flag)
                {
                    $key = array_search($row[0], array_column($users, "id"));
                    $add = $row[1] * 20;

                    if($row[2]) $add = $add + 70;
                    $scores = $users[$key]->scores;
    
                    $scores = $scores + $add;
                    $users[$key]->scores =  $row[1] != 0? $scores: $row[2] * 70;
                }
                else
                {
                    $users = addUser($row[0], $row[1], $row[2], $users);
                };
            }
            else
            {
                $users = addUser($row[0], $row[1], $row[2], $users);
            };
        };

        $top_user = [];

        foreach($users as $user)
        {
            if(count($top_user) == 0)
            {
                array_push($top_user, $user);
            }
            else
            {
                if($top_user[0]->scores < $user->scores)
                {
                    array_pop($top_user);
                    array_push($top_user, $user);
                };
            };
        };
        $user = $top_user[0];

        $query = "INSERT INTO bestofmonth(id, user_id, thatDate, scores) VALUES(0, '$user->id', '$year-$month-01', $user->scores)";
        $connect->query($query);
    };
?>