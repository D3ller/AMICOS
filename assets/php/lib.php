<?php



function connect() {
    $host_name = 'db5013211722.hosting-data.io';
    $database = 'dbs11084435';
    $user_name = 'dbu4744312';
    $password = 'maconel0477';
  
    $conn = new mysqli($host_name, $user_name, $password, $database);
  
    if ($conn->connect_error) {
      die("Échec de la connexion : " . $conn->connect_error);
    }

    return $conn;

  }
  

  function disconnect() {

    session_start();
    session_destroy();
    header('Location: /index.php');
    exit;
  }


?>