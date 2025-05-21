<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "growzone";

    $db_p = mysqli_connect($hostname, $username, $password, $database);
    $db_o = new mysqli($hostname, $username, $password, $database);
?>