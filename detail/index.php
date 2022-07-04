<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="detail.css">
    <title>Post</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito+Sans:wght@300&display=swap" rel="stylesheet"> 
</head>
<body>
    <div id="container">
        <?php
            require_once($_SERVER["DOCUMENT_ROOT"]."../forum/detail/php/post/getPost.php");
        ?>
        <section>
            <?php
                require_once($_SERVER["DOCUMENT_ROOT"]."../forum/detail/php/comment/comments.php");
            ?>
        </section>
        <?php
            require_once($_SERVER["DOCUMENT_ROOT"]."../forum/detail/php/comment/canComment.php");
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
<script src="./js/main.js" type="module"></script>
<?php
    require_once("../createCookie.php");
?>
</html>