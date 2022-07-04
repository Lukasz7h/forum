
export function showErr()
{
    const error_div = document.getElementsByClassName("errors").item(0);
    error_div.textContent = "";

    const p_err = document.createElement("p");
    p_err.textContent = "Nie podano poprawnych danych.";

    error_div.insertAdjacentElement("beforeend", p_err);
};