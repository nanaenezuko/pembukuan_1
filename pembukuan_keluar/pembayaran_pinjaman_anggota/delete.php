<?php
  require_once('../../private/initialize.php');

  $id = $_GET['id'];
  $page_title = "DELETE";
  $data = pembayaran_pinjaman_anggota_find_one($id);
  $delete_dir = PROJECT_PATH .'/uploads/pembukuan_keluar/pembayaran_pinjaman_anggota/'.$data['no_anggota'];
  $post_req = false;

  include(SHARED_PATH . '/app_header.php');
  is_admin("pembukuan_keluar/pembayaran_pinjaman_anggota");

  if (is_post_request()) {
    pembayaran_pinjaman_anggota_delete_one($id);
    delete_folder_data($delete_dir.'/'.$data['folder']);
    $post_req = true;
  } else {
    if (isset($id)) {
      if ($data['no_anggota'] == null) {
        redirect_to(url_for('/pembukuan_keluar/pembayaran_pinjaman_anggota/'));
      }
    } else {
      redirect_to(url_for('/pembukuan_keluar/pembayaran_pinjaman_anggota/'));
    }
  }
?>
  <div class="card card-wrapping">
    <form method="post" action="<?php echo url_for('/pembukuan_keluar/pembayaran_pinjaman_anggota/delete.php?id='.$id); ?>" <?php if ($post_req) {
      echo "hidden";
    } ?>>
      <h1>Apakah ingin menghapus data ini?</h1>
      <div class="mb-3">
        <label class="form-label">Id No</label>
        <input class="form-control" type="text" aria-label="" name="no" disabled value="<?php echo $id; ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Tanggal</label>
        <input class="form-control" type="text" aria-label="" name="no" disabled value="<?php echo substr($data['insert_date'], 0, 10); ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Kode Transaksi</label>
        <input class="form-control" type="text" aria-label="" name="nama" disabled value="<?php echo $data['kode_transaksi']; ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">No Anggota</label>
        <input class="form-control" type="text" aria-label="" name="nama" disabled value="<?php echo $data['no_anggota']; ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Nama Anggota</label>
        <input class="form-control" type="text" aria-label="" name="nama" disabled value="<?php echo $data['nama_anggota']; ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Lama Pinjaman</label>
        <input class="form-control" type="text" aria-label="" name="nama" disabled value="<?php echo $data['lama_pinjaman']; ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Jumlah Pinjaman</label>
        <input class="form-control" type="text" aria-label="" name="nama" disabled value="<?php echo $data['jumlah_pinjaman']; ?>">
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

  <script type="text/javascript" src="<?php echo url_for('/js/pembayaran_pinjaman_anggota.js'); ?>"></script>
<?php include(SHARED_PATH . '/app_footer.php') ?>
