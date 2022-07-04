
export class Errors
{
    err_comunacation = document.querySelector(".communication");

    //dodajemy odpowiedni błąd w zależności od napotkanych przeszkód
    addComunicat(communicat)
    {
        const newPara = document.createElement("p");

        switch(communicat)
        {
            case "err_char":
                newPara.textContent = "Tekst nie może się zaczynać lub kończyć spacją.";
            break;
            case "isset_err":
                newPara.textContent = "Istneje już użytkownik o podanym loginie.";
            break;
            case "err_login_len":
                newPara.textContent = 'Login powienien mieć od 4 do 22 znaków.';
            break;
            case "err_pass_len":
                newPara.textContent = 'Hasło powinno mieć od 7 do 30 znaków.';
            break;
            case "err_r_pass":
                newPara.textContent = 'Przepisz hasło poprawnie.';
            break;
            case "err_bot":
                newPara.textContent = "Udowodnij że nie jesteś robotem.";
            break;
        }

       this.err_comunacation.insertAdjacentElement("beforeend", newPara);
        
    }
}