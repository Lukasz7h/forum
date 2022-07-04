import { Ajax } from "./ajax.js";
import { banUser } from "./banUser.js";

import { addButtonListener } from "./listener.js";

//objekt posiadający i zwracający aktualną wartość komentarza
const commValue = {
    _commValue: "",

    set setComment(value)
    {
        this._commValue = value;
    },

    get getComment()
    {
        return this._commValue;
    }
};

const postValue = {

    _postValue: "",
    photos: [],

    set setPostValue(data)
    {
        this._postValue = data;
    },

    get getPostValue()
    {
        return this._postValue;
    },

    checkPhoto(photo, img)
    {
        if(postValue.photos.length > 0)
        {
            let check = false;
            this.photos.forEach(e => {
                if(e === photo)
                {
                    check = true;
                }
            })

            check? postValue.photos.pop(photo): postValue.photos.push(img);
        }
        else
        {
            postValue.photos.push(img);
        }
    }
};

export class Exerc extends Ajax
{ 
    commValue = "";

    //zwracamy wartość true lub false w zależności czy element istnieje w podanym rodzicu
    isset(parent, some)
    {
        return parent.querySelector(`${some}`);
    }

    //dodajemy nowy komentarz
    async addComm()
    {
       const task = document.getElementById("addComment");
       const res = await this.send({data: "add", value: task.value});

       if(res.add == true) this.refreshComments();
       if(res.ban) banUser(res.time);

       task.value = "";
    }

    //edytujemy komentarz
    editComm(button)
    {
        const divParent = button.parentNode;
        const comm = divParent.querySelector(".content_comm");

        comm.contentEditable = true;
        commValue.setComment = comm.textContent;

        comm.classList.add("to_edit");

        button.textContent = "Zaakceptuj zmiany";
        const buttonCancel = "<button class='cancel'>Anuluj</button>";

        const deleteButt = divParent.querySelector(".delete_comm");
        deleteButt.classList.remove("delete_comm");

        deleteButt.classList.add("cancel");
        deleteButt.textContent = "Anuluj";

        button.className = "save_comm";
        if(!this.isset(divParent, ".cancel"))
        {
            divParent.insertAdjacentHTML("beforeend", buttonCancel);
            const _buttonCancel = divParent.querySelector(".cancel");

            addButtonListener(_buttonCancel);
        };
    }

    //anulujemy edycje komentarza
    cancelEdit(button, flag = true)
    {
        const divParent = button.parentNode;
        const comm = divParent.querySelector(".content_comm");

        comm.contentEditable = false;
        if(flag) comm.textContent = commValue.getComment;

        divParent.querySelector(".save_comm").className = "edit_comm";
        divParent.querySelector(".edit_comm").textContent = "Edytuj";

        const cancel = divParent.querySelector(".cancel");
        cancel.classList.remove("cancel");

        cancel.classList.add("delete_comm");
        cancel.textContent = "Usuń";
    }

    //zapisujemy zedytwany komentarz
    async saveComm(button)
    {
        const divParent = button.parentNode;
        const editComm = divParent.querySelector(".content_comm").textContent;

        const id = divParent.querySelector(".content_comm").getAttribute("data-id");
        editComm === commValue.getComment?

        alert("Nie wprowadzono zmian!"):
        await this.send({data: "edit", value: editComm, id: id});
    
        this.refreshComments();
    }

    //usuwamy komentarz
    async deleteComm(button)
    {
        const divParent = button.parentNode;
        const id = divParent.querySelector(".content_comm").getAttribute("data-id");

        let post_id = new URL(document.URL);
        post_id = post_id.searchParams.get("post");

        const res = await this.send({data: "delete_comm", id: id, post_id});
        res == true? this.refreshComments(): "";
    }

    //wysyłamy zdjęcia do usunięcia
    deletePhotos()
    {
        if(postValue.photos.length > 0)
        {
            const form = new FormData();

            postValue.photos.forEach(img => {
                const images = document.querySelectorAll(`img`);
                const id = [...images].findIndex(e => e.src === img.src);

                form.append("deletePhotos[]", id);
            })

            this.send({data: "delete_photos", form: form});
        }
        else
        {
            alert("błąd");
        };
    }

    //usuwamy post
    async deletePost()
    {
        await this.send({data: "delete_post"});
        this.refreshComments();
    }

    //edytujemy wartość naszego posta
    editPost()
    {
        postValue.setPostValue = document.getElementById("post_value").textContent;
        const buttonEdit = document.getElementById("edit_post");
        const post = document.getElementById("post");

        const content = post.querySelector("p");
        const divInfo = document.createElement("div");

        content.classList.add("to_edit")

        const changePhotos = document.createElement("input");
        const deletePhotos = document.createElement("button");
        const label = document.createElement("label");

        label.htmlFor = "file";
        label.textContent = "Wybierz zdjęcia do zamiany/Dodaj nowe zdjęcia";

        changePhotos.type = "file";
        changePhotos.multiple = true;
        deletePhotos.textContent = "Usuń wybrane zdjęcia";

        changePhotos.id = "change_photos";
        deletePhotos.id = "delete_photos";

        post.querySelector("#delete_post").remove();
        post.insertAdjacentElement("beforeend", changePhotos);
        post.insertAdjacentElement("beforeend", deletePhotos);

        post.insertAdjacentElement("beforeend", label);
        addButtonListener(deletePhotos);

        changePhotos.textContent = "Zamień wybrane zdjęcia";
        changePhotos.id = "change_photos";

        post.insertAdjacentElement("beforeend", changePhotos);
        addButtonListener(changePhotos);

        const images = post.querySelectorAll("img");
        for(let i=0; i<images.length; i++)
        {
            images[i].classList.add("check");
            addButtonListener(images[i]);
        };

        content.contentEditable = true;
        buttonEdit.textContent = "Zapisz zmiany";

        buttonEdit.id = "save_post";
        divInfo.id = "info";

        divInfo.textContent = "Wybierz zdjęcia które chcesz usunąć lub zamienić lub też zmień wartość posta.";
        post.insertAdjacentElement("beforeend", divInfo);
    }

    //wysyłamy informacje do serwera o tym że komentarz o podanym id rozwiązał nasz post
    async isAnswer(button)
    {
        const commId = button.parentNode.querySelector(".content_comm").getAttribute("data-id");
        await this.send({data: "answer", id: commId});
        this.refreshComments();
    }

    //dodajemy ocene do komentarza
    async addReview(flag, some)
    {
        let comm_id = some.parentNode.getElementsByClassName("content_comm").item(0).getAttribute("data-id");
        comm_id = parseInt(comm_id);

        const res = await this.send({data: "add_review", flag: flag, id: comm_id});
        this.refreshComments();
    }

    //dodajemy zdjęcia do posta
    addPhotos(img)
    {
        const photo = img.src;
        postValue.checkPhoto(photo, img);
    }

    //zapisujemy zedytowany post
    savePost()
    {
        const allFiles = document.getElementById("change_photos").files;
        const changePost = document.getElementById("post_value");

        changePost.classList.remove("to_edit");

        const postId = document.getElementById("post").getAttribute("data-post");
        const editPostButton  = document.getElementById("save_post");

        editPostButton.id = "edit_post";
        editPostButton.textContent = "Edytuj post";

        const editDeleteButton  = document.getElementById("delete_photos");

        editDeleteButton.id = "delete_post";
        editDeleteButton.textContent = "Usuń post";

        delete document.getElementById("post").querySelector("label").remove();
        delete document.getElementById("post").querySelector("input[type='file']").remove();
        delete document.getElementById("info").remove();

        if(allFiles.length === 0 && changePost.textContent === postValue.getPostValue)
        {
            alert("błąd");
        }
        else if(allFiles.length > 0)
        {
            const form = new FormData();

            for(let file of allFiles)
            {
                form.append("file[]", file);
            };

            if(changePost.textContent === postValue.getPostValue)
            {
                postValue.photos.length > 0? 
                [
                    form.append("postPhotos[]" ,postValue.photos),
                     this.send({data: "edit_post", id: postId, form: form})
                ]
                :
                this.send({data: "edit_post", id: postId, form: form});
            }
            else
            {
                form.append("newPostValue", changePost.textContent);
                postValue.photos.length > 0? 
                [
                    form.append("postPhotos[]" ,postValue.photos),
                    this.send({data: "edit_post", id: postId, form: form})
                ]
                :
                this.send({data: "edit_post", id: postId, form: form});
            };
        }
        else
        {
            const form = new FormData();
            form.append("newPostValue[]", changePost.textContent);

            this.send({data: "edit_post", id: postId, form: form});
        };
    }
}