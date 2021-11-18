<?php
  session_start();
  if (isset($_SESSION['username'])) {
    if ($_SESSION['username'] != "admin") {
      return;
    }

    echo "Login Success";
  } else {
    echo "Login Failed";
  }


 ?>
