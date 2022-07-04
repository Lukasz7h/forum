export function serviceResponse(response)
{
    const photo_err = document.getElementById("photo_err");
    const profil = document.getElementById("profil");
    response.change?
    (
        photo_err?
        (photo_err.remove(), profil.querySelector("img").src = "../profil_photos/"+response.newPhoto):
        profil.querySelector("img").src = "../profil_photos/"+response.newPhoto
    ):
    (
        !photo_err?? profil.insertAdjacentHTML("afterend", "<p>Wysyłany plik musi mieć typ jpeg, png lub gif</p>")
    )
}