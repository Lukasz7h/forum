<?php

    class CheckMonth
    {

        //jeśli podana nazwa miesiąca jest właściwa zwracamy true
        public function isAccessMonth($month)
        {
            $flag = false;

            $access_months = 
            ["styczeń", "luty", "marzec", "kwiecień", "maj", "czerwiec", 
            "lipiec", "sierpień","wrzesień", "październik", "listopad", "grudzień"];

            foreach($access_months as $access_month)
            {
               if($month === $access_month) $flag = true;
            };

            return $flag;
        }   
    };
?>