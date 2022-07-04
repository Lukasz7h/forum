<?php

    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/propertyDB.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/forgive_password/generatePassToken.php");

    class AccountData extends Connect
    {
        function __construct(object $accountData)
        {
            $this->check($accountData);
        }

        // sprawdzamy czy można wysłać na email użytkownika link ze zmianą hasła
        private function check(object $accountData)
        {
            $connect = $this->createConnect();
            $query = "SELECT id FROM users WHERE login = ? AND email = ?";

            $prepare = $connect->prepare($query);
            $prepare->bind_param("ss", $accountData->login, $accountData->email);

            $prepare->bind_result($id);
            $prepare->execute();

            $prepare->store_result();

            if($prepare->num_rows == 0)
            {
                $err = (object)array("change" => false, "error" => "unauthorize");
                echo json_encode($err);
                die;
            };

            $prepare->fetch();

            $token = "";

            do
            {
                $token = generatePasswordToken();

                $query = "SELECT COUNT(token) FROM reset_password WHERE token = '$token'";

                $isset = $connect->query($query);
                $flag = $isset->num_rows === 0? true: false;
            }
            while($flag);

            $query = "INSERT INTO reset_password(user_id, token) VALUES('$id', '$token')";
            $connect->query($query);

            $prepare->close();
            $connect->close();

            $link = "http://".$_SERVER["HTTP_HOST"]."/forum/change_password?token=".$token;
            $message = "Zmień hasło. ".$link;

            $headers = "From: mytestforumxyyw@gmail.com";
            mail($accountData->email, "Zmień hasło", $message, $headers);

            $res = (object)array("change" => true);
            echo json_encode($res);
        }
    }

    if($_POST["account_data"])
    {
        $account_data = json_decode($_POST["account_data"]);
        $check = new AccountData($account_data);
    }
?>