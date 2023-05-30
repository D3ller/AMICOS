<?php

function connect() {
  $host_name = 'db5013211722.hosting-data.io';
  $database = 'dbs11084435';
  $user_name = 'dbu4744312';
  $password = 'maconel0477';

  $dsn = "mysql:host=$host_name;dbname=$database;charset=utf8mb4";

  try {
      $dbh = new PDO($dsn, $user_name, $password);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $dbh;
  } catch(PDOException $e) {
      die("Échec de la connexion : " . $e->getMessage());
  }
}

?>