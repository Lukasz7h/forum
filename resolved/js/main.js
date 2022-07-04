import { AddListener } from "./addListener.js";

class Init extends AddListener
{
    
    addListener()
    {
        const posts = document.getElementsByTagName("main").item(0).getElementsByTagName("div");
        this.addListenerForPosts(posts);

        const inputFind = document.getElementById("search").querySelector("input");
        const inputPeriod = document.getElementById("period").querySelector("input");
        const selectPeriod = document.getElementById("panel").querySelector("select");

        this.addListenerForPanel([inputFind, inputPeriod, selectPeriod]);
    };
};

window.onload = () => {

    const init = new Init();
    init.addListener();
};