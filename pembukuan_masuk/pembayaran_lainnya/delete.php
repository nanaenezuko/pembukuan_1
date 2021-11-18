<?php
  require_once('../../private/initialize.php');

  $id = $_GET['id'];
  $page_title = "DELETE";
  $post_req = false;

  include(SHARED_PATH . '/app_header.php');
  is_admin("pembukuan_masuk/pembayaran_lainnya");

  if (is_post_request()) {
    pembayaran_lainnya_delete_one($id);
    $post_req = true;
  } else {
    if (isset($id)) {
      $data = pembayaran_lainnya_find_one($id);
      if ($data['no_kwitansi_penerimaan'] == null) {
        redirect_to(url_for('/pembukuan_masuk/pembayaran_lainnya/'));
      }
    } else {
      redirect_to(url_for('/pembukuan_masuk/pembayaran_lainnya/'));
    }
  }
?>
  <div class="card card-wrapping">
    <form method="post" action="<?php echo url_for('/pembukuan_masuk/pembayaran_lainnya/delete.php?id='.$id); ?>" <?php if ($post_req) {
      echo "hidden";
    } ?>>
      <h1>Apakah ingin menghapus data ini?</h1>
      <div class="mb-3">
        <label class="form-label">No</label>
        <input class="form-control" type="text" placeholder="" aria-label="" name="no" disabled value="<?php echo $id; ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Tanggal</label>
        <input class="form-control" type="text" placeholder="" aria-label="" name="" disabled value="<?php echo $data['insert_date']; ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">No Kwitansi/Kode Penerimaan</label>
        <input class="form-control" type="text" placeholder="" aria-label="" name="" disabled value="<?php echo $data['no_kwitansi_penerimaan']; ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Uraian</label>
        <textarea class="form-control form-control" name="uraian" placeholder="Input Uraian" id="input_uraian" style="height: 100px" required disabled><?php echo $data['uraian']; ?></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Jumlah</label>
        <input class="form-control" type="number" placeholder="" aria-label="" name="" disabled value="<?php echo $data['jumlah']; ?>">
      </div>
      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button class="btn btn-outline-primary me-md-2" type="button" id="btn_cancel_delete">Cancel</button>
        <input type="submit" name="submit" value="Hapus" class="btn btn-primary text-white">
      </div>
    </form>
    <div class="delete_success" <?php if (!$post_req) {
      echo "hidden";
    } ?>>
      <h1>*Delete Data Success</h1>
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
  </div>

  <script type="text/javascript" src="<?php echo url_for('/js/pembayaran_lainnya.js'); ?>"></script>
<?php include(SHARED_PATH . '/app_footer.php') ?>
