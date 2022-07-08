<?php

    require $_SERVER["DOCUMENT_ROOT"].'/forum/profil/php/includes/PHPMailer.php';
	require $_SERVER["DOCUMENT_ROOT"].'/forum/profil/php/includes/SMTP.php';
	require $_SERVER["DOCUMENT_ROOT"].'/forum/profil/php/includes/Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

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

            $mail = new PHPMailer(true);							
            $mail->isSMTP();											

            $mail->Host	 = 'smtp.gmail.com';					
            $mail->SMTPAuth = true;							

            $mail->Username = 'luuukasz368@gmail.com';				
            $mail->Password = 'uxyecwfhnadxtvck';						

            $mail->SMTPSecure = 'tls';							
            $mail->Port	 = 587;

            $mail->setFrom('mytestforumxyyw@gmail.com', 'Name');		
            $mail->addAddress('luuukasz368@gmail.com');

            $mail->addAddress('luuukasz368@gmail.com', 'Name');
            $mail->isHTML(true);								

            $mail->Subject = 'Weryfikacja adresu e-mail';

            $mail->Body = "<b>Zwefyrikuj swoje konto: $link</b>";
            $mail->send();

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