<?php

    require_once($_SERVER['DOCUMENT_ROOT']."../forum/propertyDB.php");
    class Authorize extends Connect
    {
        //sprawdzamy czy podany użytkownik poże modyfikować lub usuwać post
        public function modifyPost(string $userID, int $postID)
        {
            $postId = intval($postID);
            if($postId === 0) 
            {
                echo "err_post";
                return false;
            };

            $connect = $this->createConnect();
            $query = "SELECT user_id FROM users_posts WHERE user_id='$userID' AND id=$postId";

            $res=$connect->query($query);
            if($res->num_rows === 1)
            {
                $connect->close();
                return true;
            };

            $connect->close();
            exit;
        }
    }

    function authorize(string $arg)
    {
        return isset($arg)? true: false;
    };
?>