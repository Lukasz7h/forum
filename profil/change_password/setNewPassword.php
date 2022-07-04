<?php

    session_start();

    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/authorize.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/propertyDB.php");

    class ValidPassword extends Connect
    {
        function __construct(string $oldPassword, string $newPassword, string $repeatPassword)
        {
            $this->validPassword($newPassword, $oldPassword, $repeatPassword);
        }

        private function changePass(string $password)
        {
            $connect = $this->createConnect();
            $query = "UPDATE users SET password = ? WHERE id='".$_SESSION["user_id"]."'";

            $salt = "H98h^&^ffjgRUR(*7798TDFgd98assa46)&*^(gHJt&^87^%(wd4ag(T*Rd8AL9(&awwdF8F8F";

            $newPass = hash("SHA512", $password.$salt);
            $prepareQuery = $connect->prepare($query);

            $prepareQuery->bind_param("s", $newPass);
            $prepareQuery->execute();

            echo json_encode((object)array("error"=>false));
        }

        private function checkOldPassword(string $oldPassword)
        {
            $connect = $this->createConnect();
            $salt = "H98h^&^ffjgRUR(*7798TDFgd98assa46)&*^(gHJt&^87^%(wd4ag(T*Rd8AL9(&awwdF8F8F";

            $pass = hash("SHA512", $oldPassword.$salt);
            $query = "SELECT COUNT(id) FROM users WHERE password='$pass' AND login='".$_SESSION["user_login"]."' LIMIT 0, 1";

            $res = $connect->query($query);
            $count = $res->fetch_row()[0];

            if($count < 1)
            {
                echo json_encode((object)array("error"=>true, "type"=>"wrong password"));
                die;
            }
        }

        private function validPassword(string $newPassword, string $oldPassword, string $repeatPassword)
        {
            if(strlen($newPassword) < 7 || strlen($newPassword) > 30)
            {
                echo json_encode((object)array("error"=>true, "type"=>"password len"));
                die;
            };

            if($newPassword !== $repeatPassword)
            {
                echo json_encode((object)array("error"=>true, "type"=>"passwords is not same"));
                die;
            }

            $this->checkOldPassword($oldPassword);
            $this->changePass($newPassword);
        }
    }

    if(isset($_POST["password"]))
    {
        if(!authorize($_SESSION["user_login"])) die;

        $passData = json_decode($_POST["password"]);
    
        $oldPassword = $passData->oldPass;
        $newPassword = $passData->newPass;
        $repeatPassword = $passData->repeat;

        $valid = new ValidPassword($oldPassword, $newPassword, $repeatPassword);
    }
?>