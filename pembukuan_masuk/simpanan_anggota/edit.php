<?php
  require_once('../../private/initialize.php');

  $id = $_GET['id'];
  $invalid = "is-invalid";
  $valid = "is-valid";
  $validate = true;
  $check = [];
  $error = [];

  include(SHARED_PATH . '/app_header.php');
  is_admin("pembukuan_masuk/simpanan_anggota");

  if (is_post_request() && $id !== "") {
    $anggota['simpanan-pokok'] = $_POST['simpanan-pokok'];
    $anggota['simpanan-wajib'] = $_POST['simpanan-wajib'];
    $anggota['simpanan-sukarela'] = $_POST['simpanan-sukarela'];
    $result = simpanan_anggota_update_data($id, $anggota);
  }

  if ($id !== "") {
    $data = simpanan_anggota_find_one($_GET['id']);
    if (isset($data)) {
      $page_title = "Edit Data";
      $breadcumb_name = ['Pembukuan Masuk','Simpanan Anggota','Edit'];
      $breadcumb_link = ['pembukuan_masuk','pembukuan_masuk/simpanan_anggota/',
      '/pembukuan_masuk/simpanan_anggota/edit.php'];
    } else {
      redirect_to(url_for('/pembukuan_masuk/simpanan_anggota/'));
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
          <form enctype="multipart/form-data" method="post" action="<?php echo url_for('/pembukuan_masuk/simpanan_anggota/edit.php?id='.$id); ?>">
            <div class="mb-3">
              <label class="form-label">Tanggal</label>
              <input class="form-control" type="date" aria-label="" name="tanggal" id="input_tanggal_lahir" value="<?php echo date('Y-m-d'); ?>" required disabled>
            </div>
            <div class="mb-3">
              <label class="form-label">No Urut Anggota</label>
              <input class="form-control" type="text" placeholder="Input Nomor" aria-label="" name="no-urut" id="input_no_anggota" value="<?php echo $data['no_anggota']; ?>" required disabled>
            </div>
            <div class="mb-3">
              <label class="form-label">Nama Anggota</label>
              <input class="form-control" type="text" placeholder="Input Nama" aria-label="" name="nama" id="input_nama_anggota" value="<?php echo $data['nama_anggota']; ?>" required disabled>
            </div>
            <div class="mb-3">
              <label class="form-label">Simpanan Pokok</label>
              <input class="form-control <?php if (isset($error['error_input_simpanan_pokok'])) {
                echo $invalid;
              } else {
                echo $valid;
              } ?>" type="number" placeholder="Input Simpanan Pokok" aria-label="" name="simpanan-pokok" id="input_simpanan_pokok" value="<?php echo $data['simpanan_pokok']; ?>" required>
              <div id="input_simpanan_pokok_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_simpanan_pokok_feedback" class="invalid-feedback">
                Please Fill This
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Simpanan Wajib</label>
              <input class="form-control <?php if (isset($error['error_input_simpanan_wajib'])) {
                echo $invalid;
              } else {
                echo $valid;
              } ?>" type="number" placeholder="Input Simpanan Wajib" aria-label="" name="simpanan-wajib" id="input_simpanan_wajib" value="<?php echo $data['simpanan_wajib']; ?>" required>
              <div id="input_simpanan_wajib_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_simpanan_wajib_feedback" class="invalid-feedback">
                Please Fill This
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Simpanan Sukarela</label>
              <input class="form-control <?php if (isset($error['error_input_simpanan_sukarela'])) {
                echo $invalid;
              } else {
                echo $valid;
              } ?>" type="number" placeholder="Input Simpanan Sukarela" aria-label="" name="simpanan-sukarela" id="input_simpanan_sukarela" value="<?php echo $data['simpanan_sukarela']; ?>" required>
              <div id="input_simpanan_sukarela_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_simpanan_sukarela_feedback" class="invalid-feedback">
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


      <script type="text/javascript" src="<?php echo url_for('/js/simpanan_anggota.js'); ?>"></script>
<?php include(SHARED_PATH . '/app_footer.php'); ?>
