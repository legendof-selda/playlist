<?php session_start();?>
<html>
    <head>
        <title>Please Wait...</title>
    </head>
    <body>
        Redirecting...
        <?php
            session_unset();
            session_destroy();
            header("Location: index.php");
        ?>
    </body>
</html>