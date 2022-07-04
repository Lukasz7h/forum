import { UpdateView } from "./updateView.js";

export class GetPosts extends UpdateView
{

    selectPeriod(period)
    {
        let res;

        switch(period)
        {
            case "Dni":
                res = "day";
            break;
            case "Miesięcy":
                res = "month";
            break;
            case "Lat":
                res = "year";
            break;
        };

        return res;
    }

    sendData(dataSend)
    {
        const xhr = new XMLHttpRequest();
        xhr.onload = () => {
            if(xhr.status === 200)
            {
                if(xhr.readyState === 4)
                {
                    this.updatePosts(xhr.response);
                }
            }
        }
        
        dataSend.selectPeriod = this.selectPeriod(dataSend.selectPeriod);
        
        xhr.open("POST", "../resolved/php/find_solved.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("findData="+JSON.stringify(dataSend));
    }
}