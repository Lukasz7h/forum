
import { choose } from "./choose.js";

//funkcja która dodaje listener do podanych elementów
export function addButtonListener(buttons)
{
    const listen = (x) => x?.addEventListener("click", (e) => {

        if(x.type !== "file") e.preventDefault();
        if(x instanceof Image) x.classList.contains("that")? x.classList.remove("that"): x.classList.add("that");

        choose(x);
    });

    //jeśli przesłany argument jest tablicą to wywołujemy na nim pętle w której dodajemy listener dla każdego z elementów a jesli nie to po prostu dodajemy listener do elementu
    buttons instanceof Array?
    [
        buttons.forEach(button => {

            if(button instanceof HTMLCollection)
            {
                for(let i=0; i<button.length; i++)
                {
                    addButtonListener(button[i]);
                };
            }
            else
            {
                listen(button);
            };
        })
    ]:
    listen(buttons);

}