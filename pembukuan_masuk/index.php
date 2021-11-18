<?php

  require_once('../private/initialize.php');

  $page_title = "PEMBUKUAN MASUK";
  $breadcumb_name = ['Pembukuan Masuk'];
  $breadcumb_link = ['/pembukuan_masuk'];
  $app_css = "stylesheets/app.css";
  require_once(SHARED_PATH.'/app_header.php');
 ?>
   <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
       <?php generate_breadcumb($breadcumb_name, $breadcumb_link);  ?>
   </nav>

 <h1 id="page-title" class="border border-5 border-primary custom-round">PEMBUKUAN MASUK</h1>
 <div class="card card-wrapping">
   <div class="row">
     <div class="col-4 col-sm-4">
       <div class="card card-menu">
         <button id="btn_simpanan_anggota" type="button" class="btn btn-outline-primary btn-menu">
           <img src="<?php echo url_for('/assets/images/money.svg'); ?>" class="image-fluid menu-icon" alt="...">
           <h4 id="menu-title">SIMPANAN ANGGOTA</h4>
         </button>
       </div>
     </div>
     <div class="col-4 col-sm-4">
       <div class="card card-menu">
         <button id="btn_pembayaran_pinjam" type="button" class="btn btn-outline-primary btn-menu">
           <img src="<?php echo url_for('/assets/images/credit-card-1.svg'); ?>" class="image-fluid menu-icon" alt="...">
           <h4 id="menu-title">PEMBAYARAN PINJAM</h4>
         </button>
       </div>
     </div>
     <div class="col-4 col-sm-4">
       <div class="card card-menu">
         <button id="btn_lainnya" type="button" class="btn btn-outline-primary btn-menu">
           <img src="<?php echo url_for('/assets/images/tag.svg')?>" class="image-fluid menu-icon" alt="...">
           <h4 id="menu-title">LAINNYA<br></h4>
         </button>
       </div>
     </div>
   </div>
 </div>




<?php require_once(SHARED_PATH.'/app_footer.php'); ?>
