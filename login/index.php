<?php
    header('Cache-Control: no-store, no-cache, must-revalidate');
    session_start();

    $host = $_SERVER["SERVER_NAME"];
    if(isset($_SESSION["user_login"])) header("Location: http://".$host."/forum/main/");
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Audiowide&family=Kanit:wght@300&family=Press+Start+2P&family=Work+Sans:wght@300&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    
    <h2>Zaloguj się</h2>
    <form>
    <div id="has_form"></div>
        <label for="login">Login:</label>
        <input type="text" id="login">
        <label for="password">Hasło:</label>
        <input type="password" id="password">
        <button>Zaloguj się</button>
    </form>

    <section>
        <div class="errors">
        </div>
        <div class="communication">
            
        </div>
    </section>

    <a href="../forgive_password/"><button>Zapomniałem hasła</button></a>
</body>

<script type="module" src="login.js"></script>
<?php
 require_once("../createCookie.php"); 
?>

</html>