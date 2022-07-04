import { done } from "../done/done.js";
import { Errors } from "../errors/errors.js";

import { Check } from "../check/check.js";

export class Ajax
{

    //pobieramy wartość recaptchy
    fetchRecaptchaData(data)
    {
        const captcha = grecaptcha.getResponse();
        Object.defineProperty(data, "captcha", {value: captcha});

        this.connectionWithServer(data);
    }

    //wysyłamy dane do serwera a potem obsługujemy ewentualne błędy lub informujemy użytkownika o pomyślnie przeprowadzonej rejestracji
    connectionWithServer(data)
    {
        const check = new Check();
        const err = new Errors();
        
        err.err_comunacation.textContent = "";

        const result = {
            login_len: check.checkLength("login", data.loginValue),
            pass_len: check.checkLength("password", data.passwordValue),

            r_pass: check.checkRepeatPassword(),
            bot: data.captcha.length > 0
        };

        let flag = true;
        for(let e in result)
        {
            if(!result[`${e}`])
            {
                flag = false;
                err.addComunicat(`err_${e}`);
            };
        };

        if(!flag) return;

        const xhr = new XMLHttpRequest();

        xhr.onload = function(){
            if(xhr.status === 200)
            {

                if(xhr.readyState === 4)
                {
                    xhr.responseText === "ok"? done(): err.addComunicat(xhr.responseText);
                }
            }
        }

        xhr.open("POST", "../../forum/register/php/take.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.send("data="+JSON.stringify({
            login: data["loginValue"],
            password: data["passwordValue"],
            r_password: data["r_passwordValue"],
            captcha: data["captcha"]
        }));
    }
}