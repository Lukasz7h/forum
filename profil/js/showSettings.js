import { AddListener } from "./addListener.js";


export function showSettings()
{
    let settingsPanel = document.getElementById("setting_panel");
    if(settingsPanel)
    {
        settingsPanel.remove();
    }
    else
    {
        settingsPanel = document.createElement("div");
        settingsPanel.id = "setting_panel";
    
        const inputChangeEmail = document.createElement("input");
        const inputChangePassword = document.createElement("input");
        inputChangePassword.type = "password";

        inputChangeEmail.setAttribute("data-input", "email");
        inputChangePassword.setAttribute("data-input", "password");
    
        const buttonChangeEmail = document.createElement("button");
        const buttonChangePassword = document.createElement("button");

        buttonChangeEmail.id = "change_email";
        buttonChangePassword.id = "change_password";

        buttonChangeEmail.textContent = "Zmień email";
        buttonChangePassword.textContent = "Zmień hasło";

        settingsPanel.insertAdjacentElement("afterbegin", inputChangeEmail);
        settingsPanel.insertAdjacentElement("afterbegin", buttonChangeEmail);

        settingsPanel.insertAdjacentElement("afterbegin", inputChangePassword);
        settingsPanel.insertAdjacentElement("afterbegin", buttonChangePassword);

        const body = document.getElementsByTagName("body").item(0);
        body.insertAdjacentElement("beforeend", settingsPanel);

        const addListener = new AddListener();
        addListener.changeAccountData([buttonChangeEmail, buttonChangePassword]);
    };
}