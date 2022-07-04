
export class Logout
{

    // wysyłamy do serera żądanie dzięki któremu użytkownik zostaje wylogowany
    logout()
    {
        const xhr = new XMLHttpRequest();

        xhr.onload = () => {
            window.location.reload();
        }

        xhr.open("POST","../main/logout.php");
        xhr.send();
    }
}