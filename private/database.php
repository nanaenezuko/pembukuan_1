<?php

  require_once('db_credentials.php');

  function db_connect(){
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    confirm_db_connect();
    return $connection;
  }

  function db_disconnect(){
    if (isset($connection)) {
      mysqli_close($connection);
    }
  }

  function confirm_db_connect(){
    if (mysqli_connect_errno()) {
      $msg = "Database Connection Failed";
      $msg .= mysqli_connect_errno();
      $msg .= " (". mysqli_connect_errno().")";
      exit($msg);
    }
  }

  function confirm_result_set($result_set){
    if (!$result_set) {
      exit("Database Query Failed.");
    }
  }

  function db_escape($conn, $string){
    return mysqli_real_escape_string($conn, $string);
  }


 ?>
