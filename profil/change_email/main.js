import {validEmail} from "../js/validEmail.js";

const inp = document.getElementById("add_emailInp");
const button = document.getElementById("add_emailButt");

export function emailButton()
{
    button?.addEventListener("click", () => {validEmail(false, inp.value)});
};