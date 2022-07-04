<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../resolved/style.css">
    <title>Document</title>
</head>
<body>
    <main>
        <?php
            require_once("../year/take.php");
        ?>
    </main>
</body>
<script type="module" src="main.js"></script>
<script>
    window.addEventListener('load', () => {

        const xhr = new XMLHttpRequest();

        xhr.open("POST", "../cookieKey.php", true);
        xhr.send();
    });
</script>
<?php
        require_once("../createCookie.php");
?>
</html>