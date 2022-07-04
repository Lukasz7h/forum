import { banCounter, addSpan } from "./banCounter.js";
import { Listener } from "./listener.js";

    //dodajemy elementy do strony w zależności od uzyskanej odpowiedzi od serwera
    function addElement(res)
    {
        const header = document.getElementsByTagName("header").item(0);
        if(res.login && res.login.length > 0)
        {
            const button = `<button id='addPost'>Dodaj post</button>`;
            const logout = `<button id='logout'>Wyloguj się</button>`;
            const myAccount = `<button><a href="../profil/">Moje konto</a></button>`;

            const h2 = `<h2>Witaj ${res.login}!</h2>`;

            console.log(res);
            
            if(res.ban && res.can == 0)
            {
                const spanBan = document.createElement("span");

                const banTime = new Date(res.ban);
                const currentTime = new Date();

                addSpan();
                banCounter(banTime, currentTime);
            };

            header.insertAdjacentHTML("afterbegin", logout);
            header.insertAdjacentHTML("afterbegin", myAccount);

            header.insertAdjacentHTML("afterbegin", button);
            header.insertAdjacentHTML("afterbegin", h2);

            header.classList.add("login");
        }
        else
        {
            const login = "<button id='login'>Zaloguj się</button>";
            const registration = "<button id='register'>Stwórz konto</button>";

            const body = document.getElementsByTagName("body").item(0);

            header.insertAdjacentHTML("afterbegin", registration);
            header.insertAdjacentHTML("afterbegin", login);
        };

        const init = new Init();
    };

    //sprawdzamy czy istnieje klucz dla podanego użytkownika dzięki któremu uzyska dostęp do swojego konta a jeśli istnieje dodajemy nagłówek powitalny
    (() => {
        const xhr = new XMLHttpRequest();

        xhr.onload = () => {
            xhr.status === 200 && xhr.readyState === 4 && xhr.response != ""?
            addElement(JSON.parse(xhr.responseText)): addElement("");
        };

        xhr.open("POST", "../cookieKey.php", true);
        xhr.send();
    })();

class Init extends Listener
{

    _buttonPost = document.getElementById("addPost");
    _buttonLogout = document.getElementById("logout");

    _buttonRegister = document.getElementById("register");
    _buttonLogin = document.getElementById("login");

    constructor()
    {
        super();
        this.addListener();
    }

    //dodajemy listener dla przycisków
    addListener()
    {
        this.buttonPost(this._buttonPost);
        this.buttonLogout(this._buttonLogout);

        this.buttonLogin(this._buttonLogin);
        this.buttonRegister(this._buttonRegister);
    }
};