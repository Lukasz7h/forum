
import { getHost } from "../host.js";
import { Errors } from "./errors.js";

class Ajax extends Errors
{
    topic = document.getElementById("topic");
    post_value = document.getElementById("post_value");
    photo = document.getElementById("photo");

    //pobieramy wszystkie zdjęcia i wysyłamy je do sprawdzenia jeśli wszystko jest dobrze wysyłamy kolejne dane
    send()
    {
        const xhr = new XMLHttpRequest();

        xhr.onload = function()
        {
            if(xhr.status === 200 && xhr.readyState === 4)
            {
                const host = getHost();
        
                if(xhr.response === "done")
                {
                    window.location.href = "http://"+host+"/forum/main/";
                }
                else if(xhr.response === "ok")
                {
                    this.sendData(xhr)
                }
                else
                {
                    this.addError(xhr.responseText);
                };
                
            }
        }.bind(this);

        const photos = new FormData();
        const files = this.photo.files;

        for(const photo of files)
        {
            photos.append("myFiles[]", photo);
        };

        this.sendPhoto(xhr, photos);
    }

    //wysyłamy dane do weryfikacji
    sendData(xhr)
    {
        xhr.open("POST", "./php/takeDataPost.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("data="+JSON.stringify({topic: this.topic.value, post_value: this.post_value.value}));
    }

    //wysyłamy zdjęcia do weryfikacji
    sendPhoto(xhr, photos)
    {
        xhr.open("POST", "./php/take.php", true);
        xhr.send(photos);
    }
};

(() => {
    const ajax = new Ajax();
    document.querySelector("button")?.addEventListener("click", function(e){

        e.preventDefault();
        ajax.send();
    });
})();