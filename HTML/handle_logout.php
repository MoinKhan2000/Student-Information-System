<?php

    if (isset($_POST['logout'])) {
        session_start();
        session_destroy();
        echo 'logout';
        header("Location:../HTML/index.php");
    }

