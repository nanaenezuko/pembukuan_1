<?php
  require_once('../../private/initialize.php');

  $page_title = "Input Simpanan Anggota";
  $validate = true;
  $success = false;
  $invalid = "";
  $valid = "";
  $error = [];

  $anggota['tanggal'] = '';
  $anggota['no-urut'] = '';
  $anggota['nama'] = '';
  $anggota['simpanan-pokok'] = 0;
  $anggota['simpanan-wajib'] = 0;
  $anggota['simpanan-sukarela'] = 0;

  $page_title_data = "Simpanan Anggota";
  $breadcumb_name = ['Pembukuan Masuk','Simpanan Anggota','Input'];
  $breadcumb_link = ['pembukuan_masuk','pembukuan_masuk/simpanan_anggota/',
  '/pembukuan_masuk/simpanan_anggota/input.php'];
  include(SHARED_PATH . '/app_header.php');
  is_admin("pembukuan_masuk/simpanan_anggota");

  if (is_post_request()) {
    $valid = "is-valid";
    $invalid = "is-invalid";

    $anggota['no-urut'] = $_POST['no-urut'];
    $anggota['simpanan-pokok'] = $_POST['simpanan-pokok'];
    $anggota['simpanan-wajib'] = $_POST['simpanan-wajib'];
    $anggota['simpanan-sukarela'] = $_POST['simpanan-sukarela'];

    $data = anggota_masuk_find_one($anggota['no-urut']);
    $data2 = anggota_keluar_find_one($anggota['no-urut']);
    if (!isset($data) || isset($data2)) {
      $error['error_input_no_anggota'] = 1;
      $validate = false;
    }

    if (isset($data['nama_anggota'])) {
      $anggota['nama'] = $data['nama_anggota'];
    }

    if ($validate) {
        simpanan_anggota_insert_data($anggota);
        $success = true;
    }

    if ($success) {
      redirect_to(url_for('/pembukuan_masuk/simpanan_anggota/create.php'));
      exit;
    }
  }
 ?>

       <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
          <?php generate_breadcumb($breadcumb_name, $breadcumb_link);  ?>
      </nav>
      <div class="card rounded">
        <div class="bg-primary form-header">
          <h1><?php echo strtoupper($page_title_data); ?></h1>
          <h5>Input detail dari <?php echo $page_title_data; ?></h5>
        </div>
        <div class="form-page">
          <form enctype="multipart/form-data" method="post" action="<?php echo url_for('/pembukuan_masuk/simpanan_anggota/input.php'); ?>">
            <div class="mb-3">
              <label class="form-label">Tanggal</label>
              <input class="form-control <?php echo $valid; ?>" type="date" aria-label="" name="tanggal" id="input_tanggal_lahir" value="<?php echo date('Y-m-d'); ?>" required disabled>
            </div>
            <div class="mb-3">
              <label class="form-label">No Urut Anggota</label>
              <input class="form-control <?php if (isset($error['error_input_no_anggota'])) {
                echo $invalid;
              } else {
                echo $valid;
              } ?>" type="text" placeholder="Input Nomor" aria-label="" name="no-urut" id="input_no_anggota" value="<?php echo $anggota['no-urut']; ?>" required>
              <div id="input_no_anggota_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_no_anggota_feedback" class="invalid-feedback">
                Anggota Belum Terdaftar Atau Sudah Keluar Silahkan Cek Kembali Nomor Anggota
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Nama Anggota</label>
              <input class="form-control <?php echo $valid; ?>" type="text" placeholder="Input Nama" aria-label="" name="nama" id="input_nama_anggota" value="<?php echo $anggota['nama']; ?>" required disabled>
            </div>
            <div class="mb-3">
              <label class="form-label">Simpanan Pokok</label>
              <input class="form-control <?php if (isset($error['error_input_simpanan_pokok'])) {
                echo $invalid;
              } else {
                echo $valid;
              } ?>" type="number" placeholder="Input Simpanan Pokok" aria-label="" name="simpanan-pokok" id="input_simpanan_pokok" value="<?php echo $anggota['simpanan-pokok']; ?>" required>
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
              } ?>" type="number" placeholder="Input Simpanan Wajib" aria-label="" name="simpanan-wajib" id="input_simpanan_wajib" value="<?php echo $anggota['simpanan-wajib']; ?>" required>
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
              } ?>" type="number" placeholder="Input Simpanan Sukarela" aria-label="" name="simpanan-sukarela" id="input_simpanan_sukarela" value="<?php echo $anggota['simpanan-sukarela']; ?>" required>
              <div id="input_simpanan_sukarela_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_simpanan_sukarela_feedback" class="invalid-feedback">
                Please Fill This
              </div>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <button class="btn btn-outline-primary me-md-2" type="button" id="btn_cancel_delete">Cancel</button>
              <input type="submit" name="submit" value="Submit" class="btn btn-primary text-white" id="submit_create">
            </div>
          </form>
        </div>
      </div>

      <script type="text/javascript" src="<?php echo url_for('/js/simpanan_anggota.js'); ?>"></script>

<?php include(SHARED_PATH . '/app_footer.php'); ?>
