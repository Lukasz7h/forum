
import { getHost } from "../host.js";

class Listener
{
    divs = document.getElementsByTagName("div");

    //dodajemy listener dla wszystkich postów dzieki czemu po kliknięci na któryś zostaniemy przekierowani do danego postu
    addListener()
    {
        Array.from(this.divs).forEach(e => {
            e.addEventListener("click", () => {

                const id = e.getAttribute("data-post");

                const host = getHost();
                const url = `http://${host}/forum/detail/index.php?post=${id}`;

                window.location.href = url;
            })
        })
    }
}

window.addEventListener("DOMContentLoaded", function()
{
    const listener = new Listener();
    listener.addListener();
})