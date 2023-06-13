<?php



function connect() {
    $host_name = 'localhost';
    $database = 'sae202';
    $user_name = 'sae202User';
    $password = 'Adminsae202#';
  
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