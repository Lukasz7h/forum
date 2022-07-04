import { emailButton } from "../change_email/main.js";
import { AddListener } from "./addListener.js";

class Init extends AddListener
{
    constructor()
    {
        super();

        this.addButtonListenerOf();
        emailButton();

        this.initProfilPhoto();
    }

    initProfilPhoto()
    {
        const xhr = new XMLHttpRequest();
        xhr.onload = () => {
            if(xhr.status === 200)
            {
                if(xhr.readyState === 4)
                {
                    const profilImage = xhr.response;
                    const img = document.getElementById("profil").querySelector("img").src = "data:image/png;base64,"+profilImage+""
                };
            };
        };

        xhr.open("GET", "./php/showProfilPhoto.php", true);
        xhr.send();
    }
}

window.onload = () => {
    const init = new Init();
}