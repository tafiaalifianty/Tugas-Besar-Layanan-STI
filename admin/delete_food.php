<?php
    session_start();
    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])){
        header("Location: login.php");
        exit;
    }
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        
        include_once "lib/db_conf.php";

        //Menghapus gambar terkait dengan makanan yang dihapus
        $sql = "SELECT `image` FROM `food` WHERE `id`=$id;";
        $data = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($data)) {
            unlink($row['image']);
        }
        
        //Menghapus data makanan
        $sql = "DELETE FROM `food` WHERE `id`=$id;";
        
        if(mysqli_query($conn, $sql)){}
        $conn->close(); 
    }
    header("Location: food.php");
    exit;
?>