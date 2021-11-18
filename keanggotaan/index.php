<?php

  require_once('../private/initialize.php');

  $page_title = "KEANGGOTAAN";
  $breadcumb_name = ['Keanggotaan'];
  $breadcumb_link = ['/keanggotaan'];
  $app_css = "stylesheets/app.css";
  require_once(SHARED_PATH.'/app_header.php');
 ?>
 <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
     <?php generate_breadcumb($breadcumb_name, $breadcumb_link);  ?>
 </nav>

 <h1 id="page-title" class="border border-5 border-primary custom-round">KEANGGOTAAN</h1>
 <div class="card card-wrapping">
   <div class="row">
     <div class="col-4 col-sm-4">
       <div class="card card-menu">
         <button id="btn_anggota_masuk" type="button" class="btn btn-outline-primary btn-menu">
           <img src="<?php echo url_for('/assets/images/contract.svg'); ?>" class="image-fluid menu-icon" alt="...">
           <h4 id="menu-title">ANGGOTA MASUK</h4>
         </button>
       </div>
     </div>
     <div class="col-4 col-sm-4">
       <div class="card card-menu">
         <button id="btn_anggota_keluar" type="button" class="btn btn-outline-primary btn-menu">
           <img src="<?php echo url_for('/assets/images/contract-1.svg'); ?>" class="image-fluid menu-icon" alt="...">
           <h4 id="menu-title">ANGGOTA KELUAR</h4>
         </button>
       </div>
     </div>
     <div class="col-4 col-sm-4">
       <div class="card card-menu">
         <button id="btn_rekap_anggota" type="button" class="btn btn-outline-primary btn-menu">
           <img src="<?php echo url_for('/assets/images/list.svg'); ?>" class="image-fluid menu-icon" alt="...">
           <h4 id="menu-title">REKAP ANGGOTA</h4>
         </button>
       </div>
     </div>
   </div>
 </div>




<?php require_once(SHARED_PATH.'/app_footer.php'); ?>
