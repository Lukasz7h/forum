<?php
    
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/propertyDB.php");
    if(!isset($_GET["token"]))
    {
       header("Location: http://".$_SERVER["DOCUMENT_ROOT"]."../forum/main/");
       die;
    }
    class CheckParam extends Connect
    {

        public static string $token;

        function __construct(string $token)
        {
            $this->checkToken($token);
        }

        private function checkToken(string $_token)
        {
            $connect = $this->createConnect();
            $query = "SELECT user_id FROM reset_password WHERE token = ?";

            $prepare = $connect->prepare($query);
            $prepare->bind_param("s", $_token);

            $prepare->bind_result($user_id);
            $prepare->execute();

            $prepare->store_result();
            $prepare->fetch();
            
            if($prepare->num_rows === 0 || $isset_token !== $_token)
            {
                header("Location: http://".$_SERVER["HTTP_HOST"]."/forum/main/");
                die;
            };

        }
    }
    
    $check = new CheckParam($_GET["token"]);
?>