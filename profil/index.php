<?php
session_start();
    if(!isset($_SESSION["user_id"])) {
        header("Location: http://".$_SERVER["DOCUMENT_ROOT"]."/forum/main/");
        die;
    };
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>

    <?php
        require_once("./php/detailsOfAccount.php");
    ?>
    
    <a id="my_posts" href="http://localhost/forum/profil/my_posts/"><button>Moje posty</button></a>
    <div id="notification">
        <?php
            require_once("./notifications/notifications.php");
        ?>
    </div>
</body>
<script>
    window.addEventListener('load', () => {

        const xhr = new XMLHttpRequest();

        xhr.open("POST", "http://localhost/forum/cookieKey.php", true);
        xhr.send();
    });
</script>
<?php
    require_once($_SERVER["DOCUMENT_ROOT"]."/forum/createCookie.php");
?>
<script type="module" src="./js/main.js"></script>
</html>