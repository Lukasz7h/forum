
import { getHost } from "../../host.js";

export class Redirect
{
    getPostId(post)
    {
        const id = post.getAttribute("data-post");
        this.transferUser(id);
    };

    transferUser(id)
    {
        const host = getHost();
        const url = `http://${host}/forum/resolved/post.php?id=${id}`;

        window.location.href = url;
    };
}