export class Error
{
    errors = document.querySelector(".errors");

    //dodajemy pod formularzem logowania informacje o błędzie
    addError(sentence)
    {
        const p_err = document.createElement("p");
        p_err.textContent = sentence;

        if(!document.querySelector("[data-err]"))
        {
            this.errors.insertAdjacentElement("beforeend", p_err);
        };
    }
}