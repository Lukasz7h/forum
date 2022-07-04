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
    <h2>Usuń profil</h2>
    <form>
        <label for="">Login:</label>
        <input type="text">
        <label for="">Hasło:</label>
        <input type="password">
        <button type="button" id="remove_profil">Usuń konto</button>
    </form>
</body>
<script type="module" src="./remove.js"></script>
<?php
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/createCookie.php");
?>
</html>