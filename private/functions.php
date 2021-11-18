<?php

  function url_for($script_path){
    return WWW_ROOT . $script_path;
  }

  function u($string=""){
    return url_encode($string);
  }

  function raw_u($string=""){
    rawurlencode($string);
  }

  function h($string=""){
    return htmlspecialchars($string);
  }

  function error_404(){
    header($_SERVER['SERVER_PROTOCOL']. "404 NOT FOUND");
    exit();
  }

  function error_500(){
    header($_SERVER['SERVER_PROTOCOL']. "500 Internal error");
    exit();
  }

  function redirect_to($location){
    header("Location: ". $location);
    exit;
  }

  function is_post_request(){
    return $_SERVER['REQUEST_METHOD'] == 'POST';
  }

  function is_get_request(){
    return $_SERVER['REQUEST_METHOD'] == 'GET';
  }

  function generate_breadcumb($breadcumb = [], $link = []){
    $target = url_for('/');
    echo "<ol class='breadcrumb'>
       <li class='breadcrumb-item'><a href='$target'>Home</a></li>";
      for ($i=0; $i < sizeof($breadcumb); $i++) {
        $target = url_for('/'.$link[$i]);
        if (sizeof($breadcumb) - $i !== 1) {
          echo "<li class='breadcrumb-item'><a href='$target'>$breadcumb[$i]</a></li>";
        } else {
          echo "<li class='breadcrumb-item active'>$breadcumb[$i]</li></ol>";
        }
      }
  }

  function delete_folder_data($delete_dir){
    if (file_exists($delete_dir)) {
      $files = glob($delete_dir.'/*'); // get all file names
      foreach($files as $file){ // iterate files
        if(is_file($file)) {
          unlink($file); // delete file
        }
      }
      rmdir($delete_dir);
    }
  }

  function is_session_set(){
    if (!isset($_SESSION['username'])) {
      if ($_SERVER['REQUEST_URI'] != url_for("/account/login.php")) {
        redirect_to(url_for("/account/login.php"));
      }
    }
  }

  function is_admin($link){
    if ($_SESSION['status'] != "admin") {
      redirect_to(url_for("/".$link));
    }
  }

 ?>
