<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['std_related'])) {
        header("Location:./student_related.php");
        echo $_GET['std_related'];
    } elseif (isset($_GET['tchr_related'])) {
        header("Location:./teacher_related.php");
        echo $_GET['tchr_related'];
    } elseif (isset($_GET['others_related'])) {
        echo $_GET['others_related'];
    } elseif (isset($_GET['notice_related'])) {
        echo $_GET['notice_related'];
    }
}
?>