import { Send } from "./sendData.js";

class AddListener extends Send
{
    constructor(button){
        super();
        button.addEventListener("click", (e) => {
            e.preventDefault();

            const login = document.getElementById("login").value;
            const email = document.getElementById("email").value;

            this.send({login, email});
        })
    }
}

window.onload = () => {
    const button = document.getElementById("reset_pass");
    const addListener = new AddListener(button);
}