<?php
    $servername = "localhost";
    $dbname = "foodordering";
    $username = "root";
    $password = "";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    define('BASE_URL', 'http://localhost/twitter-fooder/');
?>
