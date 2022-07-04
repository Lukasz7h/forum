<?php

    require_once($_SERVER["DOCUMENT_ROOT"]."/forum/register/php/createUser.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/forum/propertyDB.php");

    class Check extends Save
    {
        
        private $loginSetting = [4, 22];
        private $passwordSetting = [7, 30];

        //sprawdzamy czy możemy zapisać dane podane przez użytkownika a jeśli nie zwracamy błąd
        public function canSave($login, $password, $r_password, $captcha)
        {
            if(!$this->checkChars($login, $password)) return "err_char";

            if(!$this->checkLogin($login)) return "log";
            if(!$this->usserIsset($login)) return "isset_err";

            if(!$this->checkPassword($password, $r_password)) return "pass";
            if(!$this->checkCaptcha($captcha)) return "err_bot";
            
            return $this->saveUser($login, $password);
        }

        //login i hasło nie mogą zaczynać lub kończyć się spacją
        private function checkChars($login, $password)
        {
            $loginFirst = substr($login, 0, 1);
            $loginLast = substr($login, strlen($login) - 1, 1);

            $passwordFirst = substr($password, 0, 1);
            $passwordLast = substr($password, strlen($password) - 1, 1);

            if($passwordFirst === " " || $passwordLast === " " || $loginFirst === " " || $loginLast === " ")
            {
                return false;
            }

            return true;
        }

        //sprawdzamy czy użytkownik udowodnił że nie jest botem
        private function checkCaptcha($captcha)
        {
            $secret_key = "6LfJB48bAAAAAGQPckJbPDd5wIFaC9QHL2wxzQJ5";

            $payload = file_get_contents(
                "https://www.google.com/recaptcha/api/siteverify?secret=".$secret_key."&response=".$captcha
            );

            $res = json_decode($payload);
            $success = $res->success;
            
            return $success;
        }

        //długość loginu
        private function checkLogin($login)
        {
            $min = $this->loginSetting[0];
            $max = $this->loginSetting[1];

            return strlen($login) >= $min && strlen($login) <= $max? true: false;
        }

        //czy użytkownik o podanym loginie już istenieje
        private function usserIsset($login)
        {

            $connect = $this->createConnect();
            $query = "SELECT COUNT(login) FROM users WHERE login = ?";

            $prepare_query = $connect->prepare($query) or die(self::SERV_ERR);
            $prepare_query->bind_param("s", $login);

            $prepare_query->bind_result($login);
            $prepare_query->execute();
            
            while($prepare_query->fetch())
            {
                $isset = $login === 1? false: true;
            }
            
            $prepare_query->close();
            $connect->close();

            return $isset;
        }

        //czy długość hasła się zgadza i czy hasła są identyczne
        protected function checkPassword($password, $r_password)
        {
            $min = $this->passwordSetting[0];
            $max = $this->passwordSetting[1];

            $flag = strlen($password) >= $min && strlen($password) <= $max? true: false;

            if(!$flag) return false;

            if($password !== $r_password)
            {
                return false;
            }

            return true;
        }
    }
?>