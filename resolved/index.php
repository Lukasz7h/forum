<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/01b5def3c4.js" crossorigin="anonymous"></script> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>
<body>
    <div id="contain">
    <div id="panel">
        <div id="search">
            <label>Szukaj postu:</label><br>
            <input input-name="input-search" type="text">
        </div>
        <div id="period">
            <input input-name="input-period" type="number">
            <br>
            <select>
                <option>Dni</option>
                <option>Miesięcy</option>
                <option>Lat</option>
            </select>
        </div>
    </div>
    <i class="fa-solid fa-angle-down"></i>
    </div>
    <main>
        <?php
            require_once("../resolved/php/find_solved.php");
        ?>
    </main>
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