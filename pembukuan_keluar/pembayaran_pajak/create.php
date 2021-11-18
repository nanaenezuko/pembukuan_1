<?php

  require_once('../../private/initialize.php');

  $page_title = "Create";
  include(SHARED_PATH . '/app_header.php');
  is_admin("pembukuan_keluar/pembayaran_pajak");
 ?>
  <div class="card card-wrapping">
    <h1>*Input Data Success</h1>
    <div class="row">
      <div class="col"></div>
      <div class="col-md-4">
        <div class="d-grid gap-2 col-6 mx-auto">
          <button type="button" name="button" class="btn btn-primary text-white" id="btn_ok_redirect"> <h5>OK</h5> </button>
        </div>
      </div>
      <div class="col"></div>
    </div>
  </div>

  <script type="text/javascript" src="<?php echo url_for('/js/pembayaran_pajak.js'); ?>"></script>
 <?php include(SHARED_PATH . '/app_footer.php') ?>
