<?php

    class ShowNotification extends Connect
    {
        function __construct(string $user_id)
        {
            $this->getNot($user_id);
        }

        function getNot(string $user_id)
        {
            $connect = $this->createConnect();
            $query = "SELECT id FROM users_posts WHERE user_id = '$user_id'";

            $res = $connect->query($query);

            $posts_id_arr = [];
            $posts = [];
            while($row = $res->fetch_row())
            {
                $post = (object)[];

                $post->id = $row[0];
                $post->comm_amount = 0;

                array_push($posts, $post);
                array_push($posts_id_arr, $row[0]);
            };

            $posts_id_string = implode(" OR id_post=", $posts_id_arr);
            $query = "SELECT id_post FROM comments WHERE id_post=".$posts_id_string;

            if($res && $res->num_rows > 0)
            {
                $res = $connect->query($query);
                while($row = $res->fetch_row())
                {
                    foreach($posts as $post)
                    {
                        if($post->id == $row[0]) $post->comm_amount++;
                    };
                };

                $posts_id_string = implode(" OR id=", $posts_id_arr);
                $query = "SELECT id, comm_amount FROM users_posts WHERE id=".$posts_id_string;

                $posts_change = [];

                $res = $connect->query($query);

                if($res && $res->num_rows > 0)
                {
                    while($row = $res->fetch_row())
                    {
                        foreach($posts as $post)
                        {
                            if($post->id == $row[0])
                            {
                                if($row[1] < $post->comm_amount) array_push($posts_change, $row[0]);
                            };
                        };
                    };
                };

                $class = count($posts_change) > 0? 'has': 'not_has';
                echo "<button class='".$class."'>Powiadomienia</button>";

                if(count($posts_change) > 0)
                {
                    echo "<div>";
                    foreach($posts_change as $post_id)
                    {
                        echo "<a href='http://localhost/forum/detail/index.php?post=".$post_id."'><div class='post'>POST</div></a>";
                    };
                    echo "</div>";
                };
            };
        }
    };

    if(isset($_SESSION["user_id"]))
    {
        $showNotification = new ShowNotification($_SESSION["user_id"]);
    };
?>