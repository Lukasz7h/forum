import {addButtonListener} from "./listener.js";

class Init
{
    constructor()
    {
        const addButton = document.getElementById("container").getElementsByTagName("button");
        addButtonListener([addButton]);
    }
}

//po załadowaniu elementów na stronie tworzymy instancje klasy Init
window.addEventListener("DOMContentLoaded", function()
{
    const init = new Init();
})