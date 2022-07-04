<?php

    // czyścimy tekst dzięki bibliotece purifier, a to z kolei sprawia że wyświetlany tekst na stronie nie będzie zawierał niebezpiecznego kodu
    require_once($_SERVER["DOCUMENT_ROOT"]."../forum/htmlpurifier/library/HTMLPurifier.auto.php");

    function clearHTML($task)
    {
        $puri = new HTMLPurifier();

        $clean = $puri->purify($task);
        return $clean;
    }
?>