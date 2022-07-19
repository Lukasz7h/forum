import { getHost } from "../../host.js";
import { clearComments, updateComments } from "./updateComments.js";

export class Ajax
{
    //wybieramy odpowiedni link i wybieramy sposób wysłania wartosci
    chooseLink(obj)
    {
        let link = "";
        let send = "";
        let flag;

        switch(obj.data)
        {
            case "add":
                link = "./php/comment/check.php";
                send = `task=${obj.value}`;
                flag = true;
            break;
            case "edit":
                link = "./php/comment/editComment.php";
                send = `edit=${obj.value}&id=${obj.id}`;
                flag = true;
            break;
            case "delete_comm":
                link = "./php/comment/deleteComment.php";
                send = `comm_id=${obj.id}&post_id=${obj.post_id}`;
                flag = true;
            break;
            case "edit_post":
                link = "./php/post/editPost.php";
                send = obj.form;
                flag = false;
            break;
            case "delete_post":
                link = "./php/post/deletePost.php";
                flag = false;
            break;
            case "delete_photos":
                link = "./php/post/deletePhotos.php";
                send = obj.form;
                flag = false;
            break;
            case "add_review":
                link = "./php/comment/addReview.php";
                send = `data=${obj.flag}&id=${obj.id}`;
                flag = true;
            break;
            case "answer":
                link = "./php/post/answer.php";
                send = `answer=${obj.id}`;
                flag = true;
            break;
        };

        return{
            link,
            send,
            flag
        };
    }

    //wywołujemy funkcje która wysyła dane a następnie po przetworzeniu danych przez serwer dostaje informacje którą zwraca
    send(obj)
    {
        const xhr = new XMLHttpRequest();
        const res = this.chooseLink(obj);

        xhr.open("POST", res.link, true);
        if(res.flag) xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    
        xhr.send(res.send);
        return new Promise((resolve) => {

            let res;
            xhr.onload = () => {
                if(xhr.status === 200)
                {
                    if(xhr.readyState === 4)
                    {
                        res = xhr.response == ""? xhr.responseText: JSON.parse(xhr.responseText);
                        return resolve(res);
                    };
                };
            };
        });
    }

    //pobieramy aktualne komentarze i przekazujemy je do funkcji aktualizującej widok
    refreshComments()
    {
        const url = "./php/comment/comments.php";
        const xhr = new XMLHttpRequest();

        xhr.onload = () => {
            if(xhr.status === 200 && xhr.readyState === 4)
            {
                let commArr = xhr.responseText;
                if(typeof commArr === "string" && commArr.length > 0)
                {
                    commArr = JSON.parse(commArr);
                    if(commArr.hasOwnProperty("isset") && !commArr.isset)
                    {
                        window.location.href = "http://"+getHost()+"/forum/main/";
                        return;
                    };

                    const result = updateComments(commArr);
                    if(result) clearInterval(Ajax.interval);
                }
                else
                {
                    clearComments();
                };
            };
        };

        const send = function()
        {
            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("post_id");
        };

        //usuwamy funkcje czasową
        if(!!Ajax.interval)
        {
            clearInterval(Ajax.interval);
            send();
        };
        Ajax.interval = setInterval(send, 5000);
    }
}

const ajax = new Ajax();
ajax.refreshComments();