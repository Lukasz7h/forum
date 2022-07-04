import { getHost } from "../../host.js";

(() => {
    const posts = document.getElementsByTagName("div");

    Array.from(posts)
    .forEach((post) => {
        post.addEventListener("click", () => {
            window.location.href = "http://"+getHost()+"/forum/detail/index.php?post="+post.getAttribute("data-post");
        });
    });
})();