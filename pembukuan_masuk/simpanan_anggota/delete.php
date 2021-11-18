<?php
  require_once('../../private/initialize.php');

  $id = $_GET['id'];
  $page_title = "DELETE";
  $post_req = false;

  include(SHARED_PATH . '/app_header.php');
  is_admin("pembukuan_masuk/simpanan_anggota");

  if (is_post_request()) {
    simpanan_anggota_delete_one($id);
    $post_req = true;
  } else {
    if (isset($id)) {
      $data = simpanan_anggota_find_one($id);
      if ($data['no_anggota'] == null) {
        redirect_to(url_for('/pembukuan_masuk/simpanan_anggota/'));
      }
    } else {
      redirect_to(url_for('/pembukuan_masuk/simpanan_anggota/'));
    }
  }
?>
  <div class="card card-wrapping">
    <form method="post" action="<?php echo url_for('/pembukuan_masuk/simpanan_anggota/delete.php?id='.$id); ?>" <?php if ($post_req) {
      echo "hidden";
    } ?>>
      <h1>Apakah ingin menghapus data ini?</h1>
      <div class="mb-3">
        <label class="form-label">No</label>
        <input class="form-control" type="text" placeholder="" aria-label="" name="no" disabled value="<?php echo $id; ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">No Urut Anggota</label>
        <input class="form-control" type="text" placeholder="" aria-label="" name="" disabled value="<?php echo $data['no_anggota']; ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Nama Anggota</label>
        <input class="form-control" type="text" placeholder="" aria-label="" name="" disabled value="<?php echo $data['nama_anggota']; ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Simpanan Pokok</label>
        <input class="form-control" type="number" placeholder="" aria-label="" name="" disabled value="<?php echo $data['simpanan_wajib']; ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Simpanan Wajib</label>
        <input class="form-control" type="number" placeholder="" aria-label="" name="" disabled value="<?php echo $data['simpanan_pokok']; ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Simpanan Sukarela</label>
        <input class="form-control" type="number" placeholder="" aria-label="" name="" disabled value="<?php echo $data['simpanan_sukarela']; ?>">
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

  <script type="text/javascript" src="<?php echo url_for('/js/simpanan_anggota.js'); ?>"></script>
<?php include(SHARED_PATH . '/app_footer.php') ?>
