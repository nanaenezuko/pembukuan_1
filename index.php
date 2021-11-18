<?php

  require_once('private/initialize.php');

  $page_title = "MAIN MENU";
  $app_css = "stylesheets/app.css";
  require_once('private/shared/app_header.php');
 ?>


      <h1 id="page-title" class="border border-5 border-primary custom-round">PEMBUKUAN</h1>
      <div class="card card-wrapping">
        <div class="row">
          <div class="col-4 col-sm-4">
            <div class="card card-menu">
              <button id="btn_keanggotaan" type="button" class="btn btn-outline-primary btn-menu">
                <img src="assets/images/networking.svg" class="image-fluid menu-icon" alt="...">
                <h4 id="menu-title">KEANGGOTAAN</h4>
              </button>
            </div>
          </div>
          <div class="col-4 col-sm-4">
            <div class="card card-menu">
              <button id="btn_pembukuan_masuk" type="button" class="btn btn-outline-primary btn-menu">
                <img src="assets/images/contract.svg" class="image-fluid menu-icon" alt="...">
                <h4 id="menu-title">PEMBUKUAN MASUK</h4>
              </button>
            </div>
          </div>
          <div class="col-4 col-sm-4">
            <div class="card card-menu">
              <button id="btn_pembukuan_keluar" type="button" class="btn btn-outline-primary btn-menu">
                <img src="assets/images/document.svg" class="image-fluid menu-icon" alt="...">
                <h4 id="menu-title">PEMBUKUAN KELUAR</h4>
              </button>
            </div>
          </div>
        </div>
      </div>




<?php require_once('private/shared/app_footer.php'); ?>
