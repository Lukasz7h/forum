<?php

    require_once($_SERVER["DOCUMENT_ROOT"]."/forum/propertyDB.php");

    class CreateID extends Connect
    {
        //sprawdzamy czy istnieje już id o tej samej wartości co utworzone przez funkcje
        private function issetID($id)
        {
            $connect = $this->createConnect();
            $query = "SELECT COUNT(id) FROM users WHERE id = '$id'";

            $result = $connect->query($query);

            $count = $result->fetch_row();

            $connect->close();
            
            return $count[0] === "1"? true: false;
        }
    
        //losujemy czy aktualna litera będzie dużą literą
        private function toUpper()
        {
            $probability = [1, 2, 3]; //prawdopodobieństwo wylosowania dużej litery 33%
    
            $toUpper = rand(1, count($probability));
            return $toUpper === 1? true: false;
        }
    

        //tworzymy unikalne id
        public function createID()
        {
            $chars = "abcdefghijklmnoprstuvwxyz0123456789";
            $id = "";
    
            for($i=0; $i<30; $i++)
            {
                $draw = rand(0, strlen($chars)-1);
                $letter = $chars[$draw];
        
                if($this->toUpper())
                {
                    $letter = strtoupper($letter);
                }
    
                $id .= $letter;
            }
    
            if($this->issetID($id))
            {
                sleep(150);
                $this->createID();
            }
            else
            {
                return $id;
            }
        }
    }
    
?>