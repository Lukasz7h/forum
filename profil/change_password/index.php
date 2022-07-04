<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
    <link rel="stylesheet" href="../../register/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Audiowide&family=Kanit:wght@300&family=Press+Start+2P&family=Work+Sans:wght@300&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <h2>Zmień hasło</h2>
    <form>
        <label>Stare hasło:</label>
        <input id="oldPassword" type="password">
        <label>Nowe hasło:</label>
        <input id="newPassword" type="password">
        <label>Powtórz nowe hasło:</label>
        <input id="repeatPassword" type="password">
        <button>Zmień hasło</button>
    </form>
</body>
<script>
    window.addEventListener('load', () => {

    const xhr = new XMLHttpRequest();

    xhr.open("POST", "http://localhost/forum/cookieKey.php", true);
    xhr.send();
    });
</script>
<script type="module" src="./change.js"></script>
</html>