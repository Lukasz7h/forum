import { showErr } from "./error.js";

export class Send
{
    send(data)
    {
        const xhr = new XMLHttpRequest();

        xhr.onload = () => {
            if(xhr.status === 200)
            {
                if(xhr.readyState === 4)
                {
                    const res = JSON.parse(xhr.response);
                    res.change? alert("Na twój email został wysłany link do zmiany hasła."): 
                    showErr();
                }
            }
        }

        xhr.open("POST", "./checkAccountData.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("account_data="+JSON.stringify(data));
    }
}