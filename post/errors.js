export class Errors
{

    errs = document.querySelector(".errs");

    //dodajemy informacje o błędzie
    addError(err)
    {
        let p_err;

        switch(err)
        {
            case "empty_value":
                p_err = `<p data-err='${err}'>Temat i treść postu nie mogą być puste.</p>`;
            break;
            case "err_type":
                p_err = `<p data-err='${err}'>Przesłany plik musi być typu: png, jpg, jpeg, gif.</p>`;
            break;
            case "err_type":
                p_err = `<p data-err='${err}'>Przesłany plik musi być typu: png, jpg, jpeg, gif.</p>`;
            break;
            case "err_count":
                p_err = `<p data-err='${err}'>Możesz przesłać do 6 plików.</p>`;
            break;
            case "err_size":
                p_err = `<p data-err='${err}'>Zdjęcie może mieć do 1MB.</p>`;
            break;
            default:
                p_err = `<p data-err='unknow_err'>Wystąpił błąd po stronie serwera proszę spróbować później.</p>`;
            break;
        }

        const err_isset = document.querySelector(`p[data-err='${err}']`);
        const err_unknow = document.querySelector(`p[data-err='unknow_err']`);

        if(!err_isset && !err_unknow)
        {
            this.errs.textContent = "";
            this.errs.insertAdjacentHTML("beforeend", p_err);
        }
    }
}