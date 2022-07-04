<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../resolved/style.css">
</head>
<body>
    <?php
        require_once("./getMyPosts.php");
    ?>
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
<script type="module" src="main.js"></script>
</html>