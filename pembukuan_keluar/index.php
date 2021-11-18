<?php

  require_once('../private/initialize.php');

  $page_title = "PEMBUKUAN KELUAR";
  $breadcumb_name = ['Pembukuan Keluar'];
  $breadcumb_link = ['/pembukuan_keluar'];
  $app_css = "stylesheets/app.css";
  require_once(SHARED_PATH.'/app_header.php');
 ?>
 <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
     <?php generate_breadcumb($breadcumb_name, $breadcumb_link);  ?>
 </nav>

 <h1 id="page-title" class="border border-5 border-primary custom-round">PEMBUKUAN KELUAR</h1>
 <div class="card card-wrapping">
   <div class="row">
     <div class="col-3 col-sm-3">
       <div class="card card-menu">
         <button id="btn_pembayaran_pinjaman_anggota" type="button" class="btn btn-outline-primary btn-menu">
           <img src="<?php echo url_for('/assets/images/coin-1.svg')?>" class="image-fluid menu-icon" alt="...">
           <h4 id="menu-title">PEMBAYARAN PINJAMAN ANGGOTA</h4>
         </button>
       </div>
     </div>
     <div class="col-3 col-sm-3">
       <div class="card card-menu">
         <button id="btn_pembayaran_pajak" type="button" class="btn btn-outline-primary btn-menu">
           <img src="<?php echo url_for('/assets/images/money-1.svg'); ?>" class="image-fluid menu-icon" alt="...">
           <h4 id="menu-title">PEMBAYARAN PAJAK<br><br></h4>
         </button>
       </div>
     </div>
     <div class="col-3 col-sm-3">
       <div class="card card-menu">
         <button id="btn_pembayaran_anggota_keluar" type="button" class="btn btn-outline-primary btn-menu">
           <img src="<?php echo url_for('/assets/images/money-bag.svg'); ?>" class="image-fluid menu-icon" alt="...">
           <h4 id="menu-title">PEMBAYARAN ANGGOTA KELUAR<br><br></h4>
         </button>
       </div>
     </div>
     <div class="col-3 col-sm-3">
       <div class="card card-menu">
         <button id="btn_belanja_operasional" type="button" class="btn btn-outline-primary btn-menu">
           <img src="<?php echo url_for('/assets/images/settings.svg'); ?>" class="image-fluid menu-icon" alt="...">
           <h4 id="menu-title">BELANJA OPERASIONAL<br><br></h4>
         </button>
       </div>
     </div>
   </div>
 </div>




<?php require_once(SHARED_PATH.'/app_footer.php'); ?>
