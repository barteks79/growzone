<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "growzone";

    $db_o = new mysqli($hostname, $username, $password, $database);
    $db_o->set_charset('utf8');
?>