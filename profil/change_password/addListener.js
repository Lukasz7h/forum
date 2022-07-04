import { SendNewPassword } from "./sendNewPassword.js";
import { ValidPasswordData } from "./validPasswordData.js";

export class AddListener extends ValidPasswordData
{
    addListenerToButton()
    {
        const button = document.querySelector("button");

        button.addEventListener("click", (e) => {

                e.preventDefault();
                const oldPassword = document.getElementById("oldPassword").value;

                const newPassword = document.getElementById("newPassword").value;
                const repeatPassword = document.getElementById("repeatPassword").value;

                if(this.validResult(newPassword, repeatPassword))
                {
                    const send = new SendNewPassword();
                    send.sendNewPassword(oldPassword, newPassword, repeatPassword);
                };
            });
    }
};