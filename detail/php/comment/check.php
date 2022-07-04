<?php

    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/detail/php/comment/addComment.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/authorize.php");

    class Check extends AddComment
    {
        //jeśli ciąg znaków nie jest pusty sprawdzamy czy zaczyna się lub kończy spacją
        public function __construct(string $task)
        {
            if(strlen($task) > 0)
            {
                echo $this->checkEmptySpace($task);
            }
            else
            {
                echo "err_len";
            }
        }

        //jeśli ciąg znaków posiada spacje na początku lub na koncu zwracamy informacje o tym a jeżeli nie to dodajemy komentarz z podaną wartością
        private function checkEmptySpace(string $task)
        {
            return $task[0] === " " || $task[strlen($task)-1] === " "? "empty_space": $this->addComment($task);
        }
    }

    //jeśli zostało wysłany nowy komentarz sprawdzamy czy osoba wysyłająca ma możliwość dodawać komentarze a następnie przechodzimy do validacji wartości podanego komentarza
    if(isset($_POST["task"]))
    {
        if(!authorize($_SESSION["user_login"])) return;
        $check = new Check($_POST["task"]); 
    }
?>