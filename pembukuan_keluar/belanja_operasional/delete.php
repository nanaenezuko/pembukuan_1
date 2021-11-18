<?php
  require_once('../../private/initialize.php');

  $id = $_GET['id'];
  $page_title = "DELETE";
  $data = belanja_operasional_find_one($id);
  $delete_dir = PROJECT_PATH .'/uploads/pembukuan_keluar/belanja_operasional/'.$data['id'];
  $post_req = false;

  include(SHARED_PATH . '/app_header.php');
  is_admin("pembukuan_keluar/belanja_operasional");

  if (is_post_request()) {
    belanja_operasional_delete_one($id);
    delete_folder_data($delete_dir);
    $post_req = true;
  } else {
    if (isset($id)) {
      if ($data['id'] == null) {
        redirect_to(url_for('/pembukuan_keluar/belanja_operasional/'));
      }
    } else {
      redirect_to(url_for('/pembukuan_keluar/belanja_operasional/'));
    }
  }
?>
  <div class="card card-wrapping">
    <form method="post" action="<?php echo url_for('/pembukuan_keluar/belanja_operasional/delete.php?id='.$id); ?>" <?php if ($post_req) {
      echo "hidden";
    } ?>>
      <h1>Apakah ingin menghapus data ini?</h1>
      <div class="mb-3">
        <label class="form-label">Id No</label>
        <input class="form-control" type="text" aria-label="" name="no" disabled value="<?php echo $id; ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Bulan</label>
        <input class="form-control" type="text" aria-label="" name="no" disabled value="<?php echo substr($data['insert_date'], 5, 2); ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Uraian Belanja</label>
        <input class="form-control" type="text" aria-label="" name="nama" disabled value="<?php echo $data['uraian_belanja']; ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Kode Transaksi</label>
        <input class="form-control" type="text" aria-label="" name="nama" disabled value="<?php echo $data['kode_transaksi']; ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Jumlah</label>
        <input class="form-control" type="text" aria-label="" name="nama" disabled value="<?php echo $data['jumlah']; ?>">
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

  <script type="text/javascript" src="<?php echo url_for('/js/belanja_operasional.js'); ?>"></script>
<?php include(SHARED_PATH . '/app_footer.php') ?>
