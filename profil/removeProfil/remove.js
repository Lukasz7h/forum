const xhr = new XMLHttpRequest();

(() => {
    xhr.open("POST", "../../../forum/cookieKey.php", true);
    xhr.send();
})();

const removeButton = document.getElementById("remove_profil");

const inpLogin = document.getElementsByTagName("input").item(0);
const inpPassword = document.getElementsByTagName("input").item(1);

removeButton.addEventListener("click", () => {

    xhr.onload = () => {
        if(xhr.status === 200){
            if(xhr.readyState === 4){
                if(JSON.parse(xhr.response).remove) window.location.href = "http://localhost/forum/main/"; 
            };
        };
    };

    xhr.open("POST", "./deleteProfil.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("profilData="+JSON.stringify({login: inpLogin.value, password: inpPassword.value}));
})