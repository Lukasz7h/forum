<?php

    // tworzymy token do zmiany hasła
    function generatePasswordToken()
    {
        $token = "";

        for($i=0; $i<25; $i++)
        {
            $randChr = chr(rand(97, 122));
            $canAddDigit = rand(1, 5);

            $token .= $randChr;

            if($canAddDigit > 3 && strlen($token) < 25)
            {
                $randDigit = rand(0, 9);
                $token .= $randDigit;
                $i++;
            }
        };

        return $token;
    }
?>