import { getHost } from "../host.js";
import { Error } from "../login/error/error.js";
import { checkWorthOfInput } from "./check/check.js";

class Login extends Error
{
    //elementy input który używamy do logowania
    loginInput = document.getElementById("login");
    passwordInput = document.getElementById("password");

    //wysyłamy dane do serwera i zwracamy odpowiedź lub też po udanym logowaniu przenosimy użytkwnika na docelową strone
    sendToService()
    {
        const loginValue = this.loginInput.value;
        const passwordValue = this.passwordInput.value;

        const result = {
            login: {flag: checkWorthOfInput("login", loginValue), task: "Login musi mieć od 4 do 22 znaków."},
            password: {flag: checkWorthOfInput("password", passwordValue), task: "Hasło musi mieć od 7 do 30 znaków."}
        };

        let canSend = true;

        this.errors.textContent = "";
        for(let e in result)
        {
            if(!result[`${e}`]["flag"])
            {
                this.addError(result[`${e}`]["task"]);
                canSend = false;
            };
        };

        if(!canSend) return;

        const xhr = new XMLHttpRequest();

        xhr.onload = function() {
            if(xhr.status === 200)
            {

                if(xhr.readyState === 4)
                {
                    const host = getHost();
                    xhr.responseText === "ok"? 
                    window.location.href = "http://"+host+"/forum/main/": 
                    this.addError("Nie podano poprawnych wartości.");
                }
            }
        }.bind(this);

        xhr.open("POST", "../login/php/take.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("data="+JSON.stringify({login: loginValue, password: passwordValue}));
    };
}

//funkcja natychmiastowa która dodaje listener na button który uruchamia funkcje wysyłającą dane do serwera
(() => {
    const login = new Login();

    const button = document.querySelector("button").addEventListener("click", function(e){
        e.preventDefault();
        login.sendToService();
    });
})();