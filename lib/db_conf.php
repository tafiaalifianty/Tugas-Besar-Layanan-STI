<?php
    <?php
    // $servername = "localhost";
    // $dbname = "foodordering";
    // $username = "root";
    // $password = "";
 
      //remote
      //$servername = "remotemysql.com";
      //$dbname = "Z5u7cYe0sx";
      //$username = "Z5u7cYe0sx";
      //$password = "Qmn3HFEjJB";
 
      $servername = "bkkprjl1njbxeoxjyfda-mysql.services.clever-cloud.com";
      $dbname = "bkkprjl1njbxeoxjyfda";
      $username = "u8moewdgzsr3zr2j";
      $password = "nr7kaG9spizKNPpZHZ2P";
   
      $conn = new mysqli($servername, $username, $password, $dbname) or die("Connect failed: %s\n". $conn -> error);

    $config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
    $config['base_url'] .= "://".$_SERVER['HTTP_HOST'];
    $config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

    define('BASE_URL', $config['base_url']);
?>
