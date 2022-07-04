<?php

    require_once($_SERVER["DOCUMENT_ROOT"]."/forum/register/php/check.php");

    class ChangePass extends Check
    {

        function __construct(string $_token = null, string $password, string $r_password)
        {
            if(!$this->checkPassword($password, $r_password))
            {
                $err = (object) array("error" => true, "type" => "wrong_pass");
                echo json_encode($err);
                die;
            }

            try
            {
                $connect = $this->createConnect();
                $query = "SELECT user_id FROM reset_password WHERE token = ?";

                $prepare = $connect->prepare($query);
                $prepare->bind_param("s", $_token);

                $prepare->bind_result($user_id);
                $prepare->execute();

                $prepare->fetch();

                if(!$user_id && empty($user_id))
                {
                    throw new Error("wrong_token");
                };

                $prepare->close();

                $salt = "H98h^&^ffjgRUR(*7798TDFgd98assa46)&*^(gHJt&^87^%(wd4ag(T*Rd8AL9(&awwdF8F8F";

                $hash_password = hash("SHA512", $password.$salt);
                $query = "UPDATE users SET password = ? WHERE id = '$user_id'";

                $prepare = $connect->prepare($query);
                $prepare->bind_param("s", $hash_password);

                $prepare->execute();
                $prepare->close();

                $query = "DELETE FROM reset_password WHERE user_id = '$user_id'";
                $connect->query($query);

                $connect->close();
                $res = (object) array("error" => false, "is_change" => true);
                echo json_encode($res);
            }
            catch(Exception $err)
            {
                echo $err;
            }
        }

    }

    if(isset($_POST["data"]))
    {
        $data = json_decode($_POST["data"]);
        $token = $data->token;

        $password = $data->password;
        $r_password = $data->r_password;

        $change = new ChangePass($token, $password, $r_password);
    }
?>