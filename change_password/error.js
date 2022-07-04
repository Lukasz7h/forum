const errors_div = document.getElementsByClassName("errors").item(0);

export function showError(err)
{
    errors_div.textContent = "";
    const p_err = document.createElement("p");

    switch(err)
    {
        case "wrong_len": p_err.textContent = "Hasło musi miec od 7 do 30 znaków.";
        break;
        case "not_same": p_err.textContent = "Hasła nie są take same.";
        break;
        case "err": p_err.textContent = "Wystąpił błąd po stronie serwera spróbuj ponownie później.";
        break;
    };

    errors_div.insertAdjacentElement("afterbegin", p_err);
}