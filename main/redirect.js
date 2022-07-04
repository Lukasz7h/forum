import { getHost } from "../host.js"

//funkcja ta przekierowywuje użytkownika na odpowiednią stronę
export function redirect(data)
{
    const host = getHost();
    switch(data)
    {
        case "login":
            window.location.href = "http://"+host+"/forum/login/";
        break;
        case "register":
            window.location.href = "http://"+host+"/forum/register/";
        break;
        case "addPost":
            window.location.href = `http://${host}/forum/post/`;
        break;
    }
}