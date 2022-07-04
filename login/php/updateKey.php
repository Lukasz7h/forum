<?php

    require_once($_SERVER["DOCUMENT_ROOT"]."/forum/propertyDB.php");

    class UpdateKey extends Connect
    {

        function __construct(string $user_id)
        {
            $this->updateKey($user_id);
        }

        //losujemy wielką litere
        private function draw()
        {
            $draw = rand(1, 3);
            return $draw === 3;
        }

        //losujemy ciąg 128 znaków
        private function createKey()
        {
            $key = "";
            for($i=0; $i<128; $i++)
            {
                $randChar = chr(rand(97, 122));

                $toUpp = $this->draw();
                if($toUpp)
                {
                    $randChar = strtoupper($randChar);
                };

                $digit = $this->draw();
                if($digit)
                {
                    $digit = rand(1,9);
                    $key .= $digit;
                };

                $key .= $randChar;
            };

            $key = substr($key, 0, 128);
            return $key;
        }

        //tworzymy klucz który następnie będzie przypisany do sesji i aktualizujemy go w bazie danych, klucz jest potrzebny by użytkownik miał dostęp do swojego konta bez ciągłego logowania się
        private function updateKey(string $user_id)
        {
            $connect = $this->createConnect();
            $key = "";

            do
            {
                $key = $this->createKey();

                $query = "SELECT COUNT(user_key) FROM users_key WHERE user_key = '$key'";
                $connect->query($query);
                
                $res = $connect->query($query)->fetch_row()[0];
            }
            while($res > 0);

            $_SESSION["user_key"] = $key;
            $query = "UPDATE users_key SET user_key='$key' WHERE id_user='$user_id'";

            $connect->query($query);
            $connect->close();
        }

    };
?>