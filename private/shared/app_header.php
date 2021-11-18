<?php is_session_set();
$user_username = $_SESSION['username'];
$user_status = $_SESSION['status'];
if ($_SERVER['REQUEST_URI'] == url_for('/')) {
  $menu_active[0] = 'active';
} elseif (substr($_SERVER['REQUEST_URI'], 11, 11) == "keanggotaan") {
  $menu_active[1] = 'active';
} elseif (substr($_SERVER['REQUEST_URI'], 11, 15) == 'pembukuan_masuk') {
  $menu_active[2] = 'active';
} elseif (substr($_SERVER['REQUEST_URI'], 11, 16) == 'pembukuan_keluar') {
  $menu_active[3] = 'active';
} elseif (substr($_SERVER['REQUEST_URI'], 11, 7) == 'account') {
  $menu_active[4] = 'active';
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
                <a class="nav-link <?php echo $menu_active['0'] ?>" aria-current="page" href="<?php echo url_for('/'); ?>">Home</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo $menu_active['1'] ?>" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Keanggotaan
                </a>
                <ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
                  <li><a class="dropdown-item" href="<?php echo url_for('/keanggotaan/anggota_masuk/index.php'); ?>">Anggota Masuk</a></li>
                  <li><a class="dropdown-item" href="<?php echo url_for('/keanggotaan/anggota_keluar/index.php'); ?>">Anggota Keluar</a></li>
                  <li><a class="dropdown-item" href="<?php echo url_for('/keanggotaan/rekap_anggota/index.php'); ?>">Rekap Anggota</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo $menu_active['2'] ?>" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Pembukuan Masuk
                </a>
                <ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
                  <li><a class="dropdown-item" href="<?php echo url_for('/pembukuan_masuk/simpanan_anggota/index.php'); ?>">Simpanan Anggota</a></li>
                  <li><a class="dropdown-item" href="<?php echo url_for('/pembukuan_masuk/pembayaran_pinjam/index.php'); ?>">Pembayaran Pinjaman</a></li>
                  <li><a class="dropdown-item" href="<?php echo url_for('/pembukuan_masuk/pembayaran_lainnya/index.php'); ?>">Lainnya</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo $menu_active['3'] ?>" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Pembukuan Keluar
                </a>
                <ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
                  <li><a class="dropdown-item" href="<?php echo url_for('/pembukuan_keluar/pembayaran_pinjaman_anggota/index.php'); ?>">Pembayaran Pinjaman Anggota</a></li>
                  <li><a class="dropdown-item" href="<?php echo url_for('/pembukuan_keluar/pembayaran_pajak/index.php'); ?>">Pembayaran Pajak </a></li>
                  <li><a class="dropdown-item" href="<?php echo url_for('/pembukuan_keluar/pembayaran_anggota_keluar/index.php'); ?>">Pembayaran Anggota Keluar</a></li>
                  <li><a class="dropdown-item" href="<?php echo url_for('/pembukuan_keluar/belanja_operasional/index.php'); ?>">Belanja Operasional</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link dropdown-toggle <?php echo $menu_active['4'] ?>" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Account
                </a>
                <ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
                  <li><a class="dropdown-item" href="<?php echo url_for('/account/account_settings.php'); ?>">Account Settings</a></li>
                  <li><a class="dropdown-item" href="<?php echo url_for('/account/logout.php'); ?>">Log Out</a></li>
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
