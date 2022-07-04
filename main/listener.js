
import { Logout } from "./logout.js";
import { redirect } from "./redirect.js";

//dodajemy listener do przycisków jeśli tylko istnieją
export class Listener extends Logout
{

     buttonPost(button)
     {
        button?.addEventListener("click", () => {

            redirect("addPost");
        })
     }

     buttonLogout(button)
     {
        button?.addEventListener("click", (e) => {
            this.logout();
        })
     }
     buttonLogin(button)
     {
        button?.addEventListener("click", () => {
            redirect("login");
        })
     }
     buttonRegister(button)
     {
        button?.addEventListener("click", () => {
            redirect("register");
        })
     }
}