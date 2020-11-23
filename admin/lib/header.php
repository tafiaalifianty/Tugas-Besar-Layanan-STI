<?php
    session_start();
    if (!(isset($_SESSION['username']) && isset($_SESSION['password']))){
        header("Location: login.php");
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
  <body>
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #000080;">
        <a class="navbar-brand pull-left" href="#">Menu Admin</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php" id="beranda">Beranda</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="food.php" id="food">Makanan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="paket.php" id="paket">Paket</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php" id="logout">Logout</a>
            </li>
        </div>
        </nav>
        <div class="container-fluid">
