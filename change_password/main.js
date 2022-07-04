import { showError } from "./error.js";
import { getHost } from "../host.js"

const password = document.getElementById("pass");
const r_password = document.getElementById("repeat_pass");

function check(e)
{
    const send = (password, r_password) => {
        const xhr = new XMLHttpRequest();

        xhr.onload = () => {
            if(xhr.status === 200)
            {
                if(xhr.readyState === 4)
                {
                    console.log(xhr.response);
                    const res = JSON.parse(xhr.response);

                    res.error? showError("err"):(alert("Hasło zostało zmienione"), window.location.href = "http://"+getHost()+"/forum/main/");
                }
            }
        }

        const search = new URLSearchParams(document.location.search);
        const token = search.get("token");

        xhr.open("POST", "./changePass.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("data="+JSON.stringify({token: token, password: password, r_password: r_password}));
    }
    e.preventDefault();

    try
    {
        const settings = {minLen: 7, maxLen: 30};
        if(password.value.length < settings.minLen || password.value.length > settings.maxLen)
        {
            throw new Error("wrong_len")
        };

        if(password.value !== r_password.value)
        {
            throw new Error("not_same")
        };

        send(password.value, r_password.value);
    }
    catch(e)
    {
        showError(e.message);
    }
}

window.onload = () => {
    const button = document.querySelector("form>button");
    button.addEventListener("click", check);
}