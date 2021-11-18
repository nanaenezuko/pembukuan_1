<?php
  require_once('../../private/initialize.php');

  $id = $_GET['id'];
  $invalid = "is-invalid";
  $valid = "is-valid";
  $validate = true;
  $check = [];
  $error = [];

  include(SHARED_PATH . '/app_header.php');
  is_admin("pembukuan_masuk/pembayaran_lainnya");

  if (is_post_request() && $id !== "") {
    $anggota['no-kwitansi'] = $_POST['no-kwitansi'];
    $anggota['uraian'] = $_POST['uraian'];
    $anggota['jumlah'] = $_POST['jumlah'];
    $result = pembayaran_lainnya_update_data($id, $anggota);
  }

  if ($id !== "") {
    $data = pembayaran_lainnya_find_one($_GET['id']);
    if (isset($data)) {
      $page_title = "Edit Data";
      $breadcumb_name = ['Pembukuan Masuk','Pembayaran Lainnya','Edit'];
      $breadcumb_link = ['pembukuan_masuk','pembukuan_masuk/pembayaran_lainnya/',
      '/pembukuan_masuk/pembayaran_lainnya/edit.php'];
    } else {
      redirect_to(url_for('/pembukuan_masuk/pembayaran_lainnya/'));
    }
  }
 ?>

       <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
          <?php generate_breadcumb($breadcumb_name, $breadcumb_link);  ?>
      </nav>
      <div class="card rounded">
        <div class="bg-primary form-header">
          <h1><?php echo strtoupper($page_title); ?></h1>
          <h5>Input detail dari <?php echo $page_title; ?></h5>
        </div>
        <div class="form-page">
          <form enctype="multipart/form-data" method="post" action="<?php echo url_for('/pembukuan_masuk/pembayaran_lainnya/edit.php?id='.$id); ?>">
            <div class="mb-3">
              <label class="form-label">Tanggal</label>
              <input class="form-control <?php echo $valid; ?>" type="date" aria-label="" name="tanggal" id="input_tanggal" value="<?php echo date('Y-m-d'); ?>" required disabled>
            </div>
            <div class="mb-3">
              <label class="form-label">No Kwitansi/Kode Penerimaan</label>
              <input class="form-control <?php if (isset($error['error_input_no_kwitansi'])) {
                echo $invalid;
              } else {
                echo $valid;
              } ?>" type="text" placeholder="Input Nomor Kwitansi" aria-label="" name="no-kwitansi" id="input_no_kwitansi" value="<?php echo $data['no_kwitansi_penerimaan']; ?>" required>
              <div id="input_no_kwitansi_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_no_kwitansi_feedback" class="invalid-feedback">
                Please Fill This
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Uraian</label>
              <textarea class="form-control form-control <?php if (isset($error['error_input_uraian'])) {
                echo $invalid;
              } else {
                echo $valid;
              } ?>" name="uraian" placeholder="Input Uraian" id="input_uraian" style="height: 100px" required><?php echo $data['uraian']; ?></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Jumlah</label>
              <input class="form-control <?php if (isset($error['error_input_jumlah'])) {
                echo $invalid;
              } else {
                echo $valid;
              } ?>" type="number" placeholder="Input Jumlah" aria-label="" name="jumlah" id="input_jumlah" value="<?php echo $data['jumlah']; ?>" required>
              <div id="input_jumlah_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_jumlah_feedback" class="invalid-feedback">
                Please Fill This
              </div>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <button class="btn btn-outline-primary me-md-2" type="button" id="btn_cancel_delete">Cancel</button>
              <input type="submit" name="submit" value="Update" class="btn btn-primary text-white" id="submit_create">
            </div>
          </form>
        </div>
      </div>


      <script type="text/javascript" src="<?php echo url_for('/js/pembayaran_lainnya.js'); ?>"></script>
<?php include(SHARED_PATH . '/app_footer.php'); ?>
