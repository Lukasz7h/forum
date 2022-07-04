//po udanej rejestracji usuwamy pole formularza i informujemy go o tym że rejestracja przebiegła pomyślnie
export function done()
{
    document.querySelector("form").remove();
    document.querySelector(".communication").remove();
    document.querySelector(".errors").remove();

    const h1 = "<h2>Rejestracja przebiegła pomyślnie.</h2>";

    document.querySelector("section").insertAdjacentHTML("beforeend", h1);
}