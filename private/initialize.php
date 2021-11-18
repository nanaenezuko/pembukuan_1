<?php

  ob_start();

  define("PRIVATE_PATH", dirname(__FILE__));
  define("PROJECT_PATH", dirname(PRIVATE_PATH));
  define("PUBLIC_PATH", PROJECT_PATH);
  define("SHARED_PATH", PRIVATE_PATH. "/shared");

  $public_end = strpos($_SERVER['SCRIPT_NAME'], 'pembukuan') + 9;
  $doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
  define("WWW_ROOT", $doc_root);

  require_once('functions.php');
  require_once('database.php');
  require_once('query_functions.php');
  require_once('validation_functions.php');

  $db = db_connect();

  session_start();
  $menu_active = ['','','','',''];
 ?>
