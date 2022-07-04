import { getHost } from "../../host.js";

export class SendNewPassword
{
    sendNewPassword(oldPassword, newPassword, repeatPassword)
    {
        const xhr = new XMLHttpRequest();

        xhr.onload = () => {
            if(xhr.status === 200)
            {
                if(xhr.readyState === 4)
                {
                    if(!xhr.response.error) window.location.href = "http://"+getHost()+"/forum/main";
                }
            }
        }

        xhr.open("POST", "./setNewPassword.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("password="+JSON.stringify({oldPass: oldPassword, newPass: newPassword, repeat: repeatPassword}));
    }
}