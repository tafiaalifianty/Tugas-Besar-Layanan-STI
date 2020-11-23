<?php
    session_start();
    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])){
        header("Location: login.php");
        exit;
    }
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        
        include_once "lib/db_conf.php";

        //Mengubah status order menjadi 1, yang berarti sudah selesai
        
        $sql = "UPDATE `order` SET `status`=1 WHERE `id`=$id;";

        if(mysqli_query($conn, $sql)){}
        $conn->close(); 
    }
    header("Location: index.php");
    exit;
?>