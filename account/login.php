<?php

  require_once('../private/initialize.php');

  $page_title = "LOGIN";
  $app_css = "stylesheets/app.css";

  $invalid = "";

  if (isset($_SESSION['username'])) {
    redirect_to(url_for(""));
  }

  if (is_post_request()) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = get_userdata($username);

    if (isset($result['username'])) {
      if ($username == $result['username']) {
        if ($password == $result['password']) {
          $_SESSION['username'] = $username;
          $_SESSION['status'] = $result['level'];
          redirect_to(url_for(""));
        } else {
          $invalid = "is-invalid";
        }
      } else {
        $invalid = "is-invalid";
      }
    } else {
      $invalid = "is-invalid";
    }
  }
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title><?php echo $page_title; ?></title>

     <link rel="stylesheet" href="<?php echo url_for('/stylesheets/app.css');?>">
     <link href="<?php echo url_for('/stylesheets/main.css');?>" rel="stylesheet">
   </head>
   <body>
     <nav class="navbar fixed-top navbar-dark bg-primary fixed-top">
       <div class="container-fluid">
         <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
           <span class="navbar-toggler-icon"></span>
         </button>
         <a class="navbar-brand" href="#"><b>PEMBUKUAN</b></a>
         <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
           <div class="offcanvas-header bg-primary">
             <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Menu</h5>
             <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
           </div>
           <div class="offcanvas-body bg-secondary">
             <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
               <li class="nav-item">
                 <a class="nav-link active" aria-current="page" href="<?php echo url_for('/'); ?>">Home</a>
               </li>
               <li class="nav-item dropdown">
                 <a class="nav-link dropdown-toggle" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                   Keanggotaan
                 </a>
                 <ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
                   <li><a class="dropdown-item" href="<?php echo url_for('/keanggotaan/anggota_masuk/index.php'); ?>">Anggota Masuk</a></li>
                   <li><a class="dropdown-item" href="<?php echo url_for('/keanggotaan/anggota_keluar/index.php'); ?>">Anggota Keluar</a></li>
                   <li><a class="dropdown-item" href="<?php echo url_for('/keanggotaan/rekap_anggota/index.php'); ?>">Rekap Anggota</a></li>
                 </ul>
               </li>
               <li class="nav-item dropdown">
                 <a class="nav-link dropdown-toggle" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                   Pembukuan Masuk
                 </a>
                 <ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
                   <li><a class="dropdown-item" href="<?php echo url_for('/pembukuan_masuk/simpanan_anggota/index.php'); ?>">Simpanan Anggota</a></li>
                   <li><a class="dropdown-item" href="<?php echo url_for('/pembukuan_masuk/pembayaran_pinjam/index.php'); ?>">Pembayaran Pinjaman</a></li>
                   <li><a class="dropdown-item" href="<?php echo url_for('/pembukuan_masuk/pembayaran_lainnya/index.php'); ?>">Lainnya</a></li>
                 </ul>
               </li>
               <li class="nav-item dropdown">
                 <a class="nav-link dropdown-toggle" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                   Pembukuan Keluar
                 </a>
                 <ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
                   <li><a class="dropdown-item" href="<?php echo url_for('/pembukuan_keluar/pembayaran_pinjaman_anggota/index.php'); ?>">Pembayaran Pinjaman Anggota</a></li>
                   <li><a class="dropdown-item" href="<?php echo url_for('/pembukuan_keluar/pembayaran_pajak/index.php'); ?>">Pembayaran Pajak </a></li>
                   <li><a class="dropdown-item" href="<?php echo url_for('/pembukuan_keluar/pembayaran_anggota_keluar/index.php'); ?>">Pembayaran Anggota Keluar</a></li>
                   <li><a class="dropdown-item" href="<?php echo url_for('/pembukuan_keluar/belanja_operasional/index.php'); ?>">Belanja Operasional</a></li>
                 </ul>
               </li>
             </ul>
           </div>
         </div>
       </div>
     </nav>

     <div class="container-fluid content-1" id="content-1">
       <div class="row">
         <div class="col"></div>
         <div class="col-md-10">
           <div class="row">
             <div class="col"></div>
             <div class="col-sm-6">
               <h1 id="page-title" class="border border-5 border-primary custom-round">LOGIN</h1>
               <div class="card card-wrapping">
                 <form method="post" action="<?php echo url_for("/account/login.php"); ?>">
                <div class="mb-3">
                  <label for="inputUsername" class="form-label">Username</label>
                  <input type="text" class="form-control <?php echo $invalid; ?>" id="inputUsername" aria-describedby="usernameHelp" name="username">
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Password</label>
                  <input type="password" class="form-control <?php echo $invalid; ?>" id="exampleInputPassword1" name="password">
                  <div id="input_kode_transaksi_feedback" class="invalid-feedback">
                    Username atau password Salah
                  </div>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
                </form>
               </div>
             </div>
             <div class="col"></div>
           </div>


<?php include(SHARED_PATH . "/app_footer.php"); ?>
