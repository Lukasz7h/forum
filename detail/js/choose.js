
import { Exerc } from "./exerc.js";

//wybierana jest funkcja adekwatna do naciśniętego elementu
export function choose(some)
{
    const exerc = new Exerc();
    var data = some.id? some.id: some.className;

    switch(data)
    {
        case "add_comm":
            exerc.addComm();
        break;
        case "cancel":
            exerc.cancelEdit(some);
        break;
        case "answer":
            exerc.isAnswer(some);
        break;
        case "save_comm":
            exerc.saveComm(some);
            exerc.cancelEdit(some, false);
        break;
        case "edit_post":
            exerc.editPost();
        break;
        case "edit_comm":
            exerc.editComm(some);
        break;
        case "delete_comm":
            exerc.deleteComm(some);
        break;
        case "delete_post":
            exerc.deletePost();
        break;
        case "delete_photos":
            exerc.deletePhotos();
        break;
        case "check":
            exerc.addPhotos(some);
        break;
        case "save_post":
            exerc.savePost(some);
        break;
        case "agree":
            exerc.addReview(true, some);
        break;
        case "not_agree":
            exerc.addReview(false, some);
        break;
    }
}