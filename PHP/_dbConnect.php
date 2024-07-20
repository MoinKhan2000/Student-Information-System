<?php
    $servername="localhost";
    $username="root";
    $password="";
    $database="sis";

    $conn=mysqli_connect($servername,$username,$password,$database);
    if($conn){
        // echo 'connected to the database';
    }else{
        echo 'Could not connected to the database';
        // die("Could not made the connection");
    }
?>
