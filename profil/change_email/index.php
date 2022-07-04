<?php

    session_start();
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/propertyDB.php");

    class HasEmail extends Connect
    {
        function __construct()
        {
            $connect = $this->createConnect();
            $query = "SELECT email FROM users WHERE id = '".$_SESSION["user_id"]."' AND email IS NOT NULL";

            $res = $connect->query($query);
            if(!$res->num_rows > 0) header("Location: http://".$_SERVER["HTTP_HOST"]."/forum/profil/");
        }
    };

    $hasEmail = new HasEmail();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Audiowide&family=Kanit:wght@300&family=Press+Start+2P&family=Work+Sans:wght@300&display=swap" rel="stylesheet"> 

    <link rel="stylesheet" href="../../register/style.css">
    <title>Document</title>
</head>
<body>
    <h2>Zmień email</h2>
    <form>
        <input type="text"><button>Zmień email</button>
    </form>
</body>
<script>
    window.addEventListener('load', () => {

    const xhr = new XMLHttpRequest();

    xhr.open("POST", "http://localhost/forum/cookieKey.php", true);
    xhr.send();
    });
</script>
<script type="module" src="main.js"></script>
</html>