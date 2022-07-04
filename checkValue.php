<?php

    function emptySpace(string $task)
    {
        return $task[0] === " " || $task[strlen($task)-1] === " "? true: false;
    }
?>