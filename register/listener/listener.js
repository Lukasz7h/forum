
import { Ajax } from "../ajax/ajax.js";
import { Check } from "../check/check.js";
import { getData } from "../check/getData.js";

export class Listener extends Check
{
    login = document.getElementById("login");
    password = document.getElementById("password");

    r_password = document.getElementById("r_password");
    button = document.querySelector("button");

    //dodajemy nasłuchiwanie na zdażenie input na każdym elemencje
    addInputListener()
    {
        this.login.addEventListener("input", () => { //wartość elementu login jest sprawdzana pod wzgledem długości

            this.checkLength( this.login.id ,this.login.value); 
        });

        this.password.addEventListener("input", () => { //wartość elementu hasło jest sprawdzana pod wzgledem długości i ustalana

            this.checkLength(this.password.id, this.password.value);
            this.setPasswordValue(this.password.id, this.password.value); 
        });

        this.r_password.addEventListener("input", () => { //wartość elementu powtórz hasło jest ustalana

            this.setPasswordValue(this.r_password.id, this.r_password.value);
        });

        this.button.addEventListener("click", (e) => { //element button pobiera dane i wysyła je do Klasy Ajax która komunikuje się z serwerem

            e.preventDefault(); 

            this.button.classList.add("anim");

            setTimeout(() => {
                this.button.classList.remove("anim");
            }, 500);
            const data = getData(this.login, this.password, this.r_password);

            const ajax = new Ajax();
            ajax.fetchRecaptchaData(data);
        })
    }
}