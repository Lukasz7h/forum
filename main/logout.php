<?php
    // niszczymy sesje i ciastko
    session_start();

    $_SESSION = array();
    setcookie("user_key", "", time()-3600, "/", "");
    
    session_destroy();
?>