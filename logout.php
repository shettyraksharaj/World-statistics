<?php
/*------start session-----*/
    session_start();
/*------Destroy session----*/
    session_destroy();
    header("Location: index.php");//Reroute to index page
?>
