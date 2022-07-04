<?php

    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/authorize.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/propertyDB.php");
    session_start();

    class CheckEmail extends Connect
    {

        function __construct(string $email)
        {
            $this->validEmail($email);
            $this->saveEmail($email);
        }

        // sprawdzanie emaila
        private function validEmail(string $email)
        {
            if(!preg_match("/^[^\s@]+@[^\s@]+\.[^\s@]+$/", $email))
            {
                $reqObj = (object)[];
                $reqObj->email_changed = false;
                $reqObj->error = "wrong email";
                $reqObj->email = $email;
                echo json_encode($reqObj);
                die;
            }
        }

        // zapisujemy wysłany email
        private function saveEmail(string $email)
        {
            $connect = $this->createConnect();
            $query = "SELECT user_id FROM verify_emails WHERE user_id = '".$_SESSION["user_id"]."'";

            $res = $connect->query($query);
            if($res->num_rows == 1)
            {
              $query = "UPDATE verify_emails SET email = ? WHERE user_id = '".$_SESSION["user_id"]."'";
            }
            else{
                $query = "INSERT INTO verify_emails(user_id, email) VALUES('".$_SESSION["user_id"]."', ?)";
            };

            $prepare = $connect->prepare($query);
            $prepare->bind_param("s", $email);

            $prepare->execute();
            $prepare->close();
            $connect->close();

            $link = "http://".$_SERVER["HTTP_HOST"]."/forum/email";
            $message = "Naciśnij na podany link aby potwierdzić, że podany e-mail należy do ciebie. ".$link;

            $headers = "From: luuukasz368@gmail.com";
            mail($email, "Weryfikacja adresu e-mail", $message, $headers);

            $reqObj = (object)[];
            $reqObj->email_changed = true;
            echo json_encode($reqObj);
        }
    }

    if(isset($_POST["email"]))
    {
        if(!authorize($_SESSION["user_id"])) die;
        $checkEmail = new CheckEmail($_POST["email"]);
    };
?>