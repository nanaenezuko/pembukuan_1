<?php
  require_once('../../private/initialize.php');

  $id = $_GET['id'];
  $page_title = "DELETE";
  $delete_dir = PROJECT_PATH .'/uploads/keanggotaan/anggota_masuk/'.$id;
  $post_req = false;
  $delete_msg = '*Delete Data Success';
  $color_error = '';

  include(SHARED_PATH . '/app_header.php');
  is_admin("keanggotaan/anggota_masuk");

  if (is_post_request()) {
    $result = anggota_masuk_delete_one($id);
    if (!$result) {
      $delete_msg ='*Data Tidak Dapat Dihapus Dikarenakan Terkait Dengan Data Di From Lain';
      $color_error = 'red';
    }
    delete_folder_data($delete_dir);
    $post_req = true;
  } else {
    if (isset($id)) {
      $data = anggota_masuk_find_one($id);
      if ($data['no_anggota'] == null) {
        redirect_to(url_for('/keanggotaan/anggota_masuk/'));
      }
    } else {
      redirect_to(url_for('/keanggotaan/anggota_masuk/'));
    }
  }
?>
  <div class="card card-wrapping">
    <form method="post" action="<?php echo url_for('/keanggotaan/anggota_masuk/delete.php?id='.$id); ?>" <?php if ($post_req) {
      echo "hidden";
    } ?>>
      <h1>Apakah ingin menghapus data ini?</h1>
      <div class="mb-3">
        <label class="form-label">No Urut Anggota</label>
        <input class="form-control" type="text" placeholder="Nomor Anggota" aria-label="" name="no" disabled value="<?php echo $id; ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Nama Anggota</label>
        <input class="form-control" type="text" placeholder="Nomor Anggota" aria-label="" name="nama" disabled value="<?php echo $data['nama_anggota']; ?>">
      </div>
      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button class="btn btn-outline-primary me-md-2" type="button" id="btn_cancel_delete">Cancel</button>
        <input type="submit" name="submit" value="Hapus" class="btn btn-primary text-white">
      </div>
    </form>
    <div class="delete_success" <?php if (!$post_req) {
      echo "hidden";
    } ?>>
      <h1 style="color: <?php echo $color_error; ?>;"><?php echo strtoupper($delete_msg); ?></h1>
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

  <script type="text/javascript" src="<?php echo url_for('/js/anggota_masuk.js'); ?>"></script>
<?php include(SHARED_PATH . '/app_footer.php') ?>
