export class ChangeStyle
{

    //nadajemy odpowiedni styl który mówi użytkownikowi o poprawności wpisanych danych
    changeStyle(flag, inputName)
    {
        const err_div = document.querySelector(`div[data-inp="${inputName}"]`);
        
        if(flag && err_div.className === `err_${inputName}`)
        {
            err_div.classList.remove(`err_${inputName}`);
            err_div.classList.add("well");
        }
        else if(!flag && err_div.className !== `err_${inputName}`)
        {
            err_div.classList.remove(`well`);
            err_div.classList.add(`err_${inputName}`);    
        }
    }
}