import { updateProfilPhoto } from "./sendData.js";
import { showNotifications } from "./notificationStyle.js";

export class AddListener
{
    addButtonListenerOf()
    {
        const input = document.getElementById("profil").querySelector("input");
        input.addEventListener("input", () => {
            
            const photo = input.files.item(0);
            updateProfilPhoto(photo);
        });

        const buttonNotification = document.getElementById("notification")
        .getElementsByTagName("button").item(0);

        const notificationContainer = document.getElementById("notification")
        .getElementsByTagName("div").item(0);

        let show = false;

        if(notificationContainer?.childNodes.length > 0)
        buttonNotification.addEventListener("click", () => {
            show = showNotifications(show, notificationContainer);
        });
    }
};