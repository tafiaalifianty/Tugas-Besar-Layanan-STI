<?php
    session_start();
    if (isset($_SESSION['username']) && isset($_SESSION['password'])){
        header("Location: index.php");
        exit;
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--<link rel="icon" href="../img/logo_header.png">-->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>

    <title>Food Order System - Admin</title>
  </head>
  <body style="background-color: #000080;">
    <div class="container-fluid">
