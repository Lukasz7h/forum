import { GetPosts } from "./getPosts.js";

export class InputExerc extends GetPosts
{

    chooseExerc()
    {
       if(GetPosts.sendAfterTime)
       {
            clearInterval(GetPosts.sendAfterTime);
            GetPosts.sendAfterTime = null;
       };

       GetPosts.sendAfterTime = setTimeout(() => {

        const inputSearch = document.getElementById("search").querySelector("input").value;
        const inputPeriod = document.getElementById("period").querySelector("input").value;
        const selectPeriod = document.getElementById("period").querySelector("select").value;

        this.sendData({inputSearch, inputPeriod, selectPeriod});
        GetPosts.sendAfterTime = null;

       }, 1500);
    };
}