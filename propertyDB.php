<?php

    class Connect
    {
        //błędy wyświetlane przy nieudanej próbie wysłania zapytania i nieudanej próbie połączenia z serwerem
        protected CONST SERV_ERR = "Błąd serwera najmocniej przepraszamy!";
        protected CONST CONNECT_ERR = "Nie można się połączyć z bazą danych.";

        //dane do połączenia się z bazą danych
        private CONST HOST = "localhost";
        private CONST NAME = "root";
        private CONST PASSWORD = "";
        private CONST BASE = "forum";

        //zwracamy utworzone połączenie
        protected function createConnect()
        {
            $connect = @mysqli_connect(self::HOST, self::NAME, self::PASSWORD, self::BASE)or die(self::CONNECT_ERR);
            return $connect;
        }
    };
    
?>