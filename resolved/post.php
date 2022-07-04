<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rozwiązane</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet"> 

    <link rel="stylesheet" href="../detail/detail.css">
</head>
<?php
    require_once($_SERVER["DOCUMENT_ROOT"]."/forum/detail/php/post/getPost.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/forum/detail/php/comment/comments.php");

    class FindPost extends GetPost
    {
        function __construct($id)
        {
            $this->getPost($id, false);
            $comments = new Comments($id, false);
        }
    };

    if(isset($_GET["id"]) && !isset($_GET["post"]))
    {
        $id = intval($_GET["id"]);
        if($id === 0)
        {
            header("Location: http://".$_SERVER["HTTP_HOST"]."/forum/main");
            die;
        }

        $check = new FindPost($id);
    }
    else{
        header("Location: http://".$_SERVER["HTTP_HOST"]."/forum/main");
        die;
    };
?>
<script>
    window.addEventListener('load', () => {

        const xhr = new XMLHttpRequest();

        xhr.open("POST", "http://localhost/forum/cookieKey.php", true);
        xhr.send();
    });
</script>
</html>