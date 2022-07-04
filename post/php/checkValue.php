<?php

    //sprawdzamy czy temat i opis posta mają właściwą długość
    function checkValue($values)
    {
        $flag = false;

        foreach($values as $e)
        {
            $e = trim($e);
            
            if(strlen($e) === 0)
            {
                $flag = true;
            }
        }

        return $flag;
    }
    
?>