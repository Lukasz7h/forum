<?php
    //exportujemy kod js typu string który wysyłał rządanie mające na celu odświerzenie ciastka
    echo "<script type='module'>
            import { getHost } from 'http://localhost/forum/host.js';

            const url = 'http://'+getHost()+'/forum/main/keyToCookie.php';

            window.addEventListener('beforeunload', () => {
            navigator.sendBeacon(url);
        });
    </script>";
?>