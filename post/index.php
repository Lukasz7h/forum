<?php
    session_start();
    header('Cache-Control: no-store, no-cache, must-revalidate');

    $host = $_SERVER["SERVER_NAME"];
    if(!isset($_SESSION["user_login"])) 
    {
        header("Location: http://".$host."/forum/main/");
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="addPost.css">
</head>
<body>
    <form>
        <label for="Topic">Temat:</label>
        <input type="text" id="topic">
        <label for="post_value">Treść:</label>
        <textarea id="post_value" cols="55" rows="20"></textarea>
        <input id="photo" type="file" multiple>
        <button>Dodaj post</button>
    </form>
    <div class="errs"></div>
</body>
<script type="module" src="main.js"></script>
<script>
    window.addEventListener('load', () => {
        const xhr = new XMLHttpRequest();

        xhr.open("POST", "http://localhost/forum/cookieKey.php", true);
        xhr.send();
    });
</script>
<?php
    require_once("../createCookie.php");
?>
</html>