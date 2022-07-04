import { SendData } from "./sendData.js";

export function validEmail(flag = false, email)
{
    try
    {
        const emailValue = flag? document.getElementById("add_emaiInp")?.querySelector("input").value: email;
        const regEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if(regEmail.exec(emailValue) === null)
        {
            throw new Error("Proszę podać prawidłowy email.")
        };

        const send = new SendData();
        send.send({url: "./php/checkEmail.php", value: email, so: "email"});
    }
    catch(e)
    {
        console.log(e.message);
    }
};