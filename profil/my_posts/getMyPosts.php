<?php
    session_start();

    require_once($_SERVER["DOCUMENT_ROOT"]."./forum/propertyDB.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/clearHTML.php");

    class MyPosts extends Connect
    {
        function __construct(string $user_id)
        {
            function showPosts($res)
            {
                if($res->num_rows > 0)
                {
                    while($row = $res->fetch_row())
                    {
                        echo "<div class='post' data-post='".$row[0]."'>
                            <span>".clearHTML($row[1])."</span>
                            <span>".substr(clearHTML($row[2]),0 ,200)."</span>
                            <span>".$row[3]."</span>
                        </div>";
                    };
                }
                else
                {
                    echo "<p>Tu nic nie ma.</p>";
                };
                
            };

            $connect = $this->createConnect();
            $query = "SELECT id, topic, post_value, post_date FROM users_posts WHERE user_id = '$user_id'";

            $res = $connect->query($query);
            echo "<main>";
            
            echo "<h3>Nierozwiązane posty</h3>";
            showPosts($res);

            $query = "SELECT id, topic, post_value, post_date FROM solved WHERE user_id = '$user_id'";
            $res = $connect->query($query);

            echo "<h3>Rozwiązane posty</h3>";
            showPosts($res);

            echo "</main>";
        }
    }

    isset($_SESSION["user_id"])? $getPost = new MyPosts($_SESSION["user_id"]):
    header("Location: http://".$_SERVER["SERVER_NAME"]."/forum/main/");
?>