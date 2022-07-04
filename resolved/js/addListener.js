import { InputExerc } from "./inputExerc.js";
import { Redirect } from "./redirect.js";

export class AddListener
{
    addListenerForPosts(post)
    {
        const redirect = new Redirect();
        Array.from(post).forEach(e => e.addEventListener("click", () => {redirect.getPostId(e)}));
    };

    addListenerForPanel(inputesArray)
    {
        const inputExerc = new InputExerc();
        inputesArray.forEach(input => input.addEventListener("input", () => {inputExerc.chooseExerc()}) );
    };
};