import { getHost } from "../../host.js";
import { addButtonListener } from "./listener.js";

//dodajemy komentarz
function addComment(comment)
{
    console.log(comment);
    const section = document.querySelector("section");

    const commentDiv = document.createElement("div");
    commentDiv.classList.add("comment");

    const scoresParagraph = document.createElement("p");
    const spanCount = document.createElement("span");

    spanCount.classList.add("count");
    spanCount.textContent = comment.scores;

    const spanRank = document.createElement("span");
    spanRank.classList.add("rank");

    spanRank.textContent = comment.rank;

    scoresParagraph.insertAdjacentElement("beforeend",spanCount);
    scoresParagraph.innerHTML += " - ";

    scoresParagraph.insertAdjacentElement("beforeend",spanRank);
    scoresParagraph.classList.add("scores");

    const img = document.createElement("img");
    img.src = "data:image/png; base64, "+comment.photo;

    const spanLogin = document.createElement("span");
    spanLogin.textContent = comment.login;

    const spanDate = document.createElement("span");
    spanDate.textContent = comment.date;

    const paragraphCommentValue = document.createElement("p");
    paragraphCommentValue.classList.add("content_comm");

    paragraphCommentValue.setAttribute("data-id", comment.id);
    paragraphCommentValue.textContent = comment.value;

    commentDiv.insertAdjacentElement("beforeend", spanLogin);
    commentDiv.insertAdjacentElement("beforeend", spanDate);

    commentDiv.insertAdjacentElement("beforeend", scoresParagraph);
    commentDiv.insertAdjacentElement("beforeend", img);

    section.insertAdjacentElement("beforeend", commentDiv);
    commentDiv.insertAdjacentElement("beforeend", paragraphCommentValue);

    if(comment.id_user)
    {
        const buttonEdit = document.createElement("button");
        buttonEdit.classList.add("edit_comm");
        buttonEdit.textContent = "Edytuj";
    
        const buttonDelete = document.createElement("button");
        buttonDelete.classList.add("delete_comm");
        buttonDelete.textContent = "Usuń";

        commentDiv.insertAdjacentElement("beforeend", buttonEdit);
        commentDiv.insertAdjacentElement("beforeend", buttonDelete);

        addButtonListener([buttonEdit, buttonDelete]);
    };

    if(!comment.id_user && comment.author)
    {
        const answerButton = document.createElement("button");
        answerButton.classList.add("answer");
        answerButton.textContent = "Odpowiedź";

        commentDiv.insertAdjacentElement("beforeend", answerButton);
        addButtonListener(answerButton);
    };

    if(comment.canReview)
    {
        let agree;
        let not_agree;
        let review;

        comment.id_user? 
        [
            review = document.createElement("p"),
            review.classList.add("review"),
        ]:
        [
            agree = document.createElement("button"), 
            agree.classList.add("agree"),
            not_agree = document.createElement("button"),
            not_agree.classList.add("not_agree")
        ];
        if(agree && not_agree)
        {
            const span = "<span> 0</span>";
            agree.innerHTML = `Zgadzam się ${span}`;
            commentDiv.insertAdjacentElement("beforeend", agree);
            not_agree.innerHTML = `Nie zgadzam się ${span}`;
            commentDiv.insertAdjacentElement("beforeend", not_agree);
        }
        else if(review)
        {
            let span = "<span class='agree_count'>0</span>";
            review.innerHTML = `Zgadza się ${span}`;
            span = "<span class='not_agree_count'>0</span>";
            review.innerHTML += `Nie zgadza się ${span}`;
            commentDiv.insertAdjacentElement("beforeend", review);
        };

        if(!comment.id_user) addButtonListener([agree, not_agree]);
    };
}

//aktualizujemy widok komentarzy dla danego posta
export function updateComments(arr)
{
    const comments = document.getElementsByClassName("content_comm");
    let answer = false;

    for(let comment of arr)
    {
        const that = document.querySelector(`[data-id='${comment.id}']`);
        let span = that?.parentNode?.querySelector(".agree")?.querySelector("span") || that?.parentNode?.querySelector(".review")?.querySelector(".agree_count");

        if(that && that.textContent !== comment.value && !that.isContentEditable) that.textContent = comment.value;
        if(span?.textContent != comment.is_agree && span) span.textContent = comment.is_agree;

        span = that?.parentNode?.querySelector(".not_agree")?.querySelector("span") || that?.parentNode?.querySelector(".review")?.querySelector(".not_agree_count");
        if(span?.textContent !== comment.not_agree && span) span.textContent = comment.not_agree;

        let scores = that?.parentNode?.querySelector(".scores")?.querySelector(".count");
        if(scores && scores.textContent != comment.scores) scores.textContent = comment.scores;

        if(comment.solution == 1) answer = true;
        if(that === null) addComment(comment);
    };

    Array.from(comments).forEach(element => {
        const id = element.getAttribute("data-id");
        const removeComment = arr.filter(e => e.id == id)[0];

        if(removeComment === undefined || !removeComment) element.parentNode.remove();
    });
};

//usuwamy wszystkie komentarze
export function clearComments()
{
    const section = document.querySelector("section");
    section.textContent = "";
};