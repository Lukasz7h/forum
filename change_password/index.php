<?php
    require_once("./checkParam.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <link href="https://fonts.googleapis.com/css2?family=Audiowide&family=Kanit:wght@300&family=Press+Start+2P&family=Work+Sans:wght@300&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Zmien hasło</title>
</head>
<body>
    <h2>Zmień hasło</h2>
    <form>
        <div id="has_form"></div>
        <label>Nowe hasło:</label>
        <input id="pass" type="password">
        <label>Potwierdź hasło:</label>
        <input id="repeat_pass" type="password">
        <button id="change">Zmień hasło</button>
    </form>

    <div class="errors">

    </div>
</body>
<script type="module" src="./main.js"></script>
</html>