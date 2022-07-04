import { AddListener } from "./addListener.js";

export class UpdateView
{
    article = document.getElementsByTagName("article").item(0);

    updatePosts(postResponse)
    {
        this.article.innerHTML = postResponse;
        const posts = document.getElementsByTagName("article").item(0).querySelectorAll("div");

        const listener = new AddListener();
        listener.addListenerForPosts(posts);
    }
}