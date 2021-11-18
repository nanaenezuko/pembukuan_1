<?php
  require_once('../../private/initialize.php');

  $page_title = "Input Pembayaran Pinjam";
  $validate = true;
  $success = false;
  $invalid = "";
  $valid = "";
  $error = [];
  $month = date('m');
  $m_selected = ['01' => '','02' => '','03' => '','04' => '','05' => '',
                '06' => '','07' => '','08' => '','09' => '','10' => '',
                '11' => '', '12' => ''];
  $m_selected[$month] = "selected";

  $anggota['tanggal'] = '';
  $anggota['no-urut'] = '';
  $anggota['nama'] = '';
  $anggota['pembayaran-bulan'] = 0;
  $anggota['pokok-pinjaman'] = 0;
  $anggota['bagi-hasil'] = 0;
  $anggota['ujrah'] = 0;

  $page_title_data = "Pembayaran Pinjam";
  $breadcumb_name = ['Pembukuan Masuk','Pembayaran Pinjam','Input'];
  $breadcumb_link = ['pembukuan_masuk','pembukuan_masuk/pembayaran_pinjam/',
  '/pembukuan_masuk/simpanan_anggota/input.php'];
  include(SHARED_PATH . '/app_header.php');
  is_admin("pembukuan_masuk/pembayaran_pinjam");

  if (is_post_request()) {
    $valid = "is-valid";
    $invalid = "is-invalid";

    $anggota['tanggal'] = $_POST['tanggal'];
    $anggota['no-urut'] = $_POST['no-urut'];
    $anggota['pembayaran-bulan'] = $_POST['pembayaran-bulan'];
    $anggota['pokok-pinjaman'] = $_POST['pokok-pinjaman'];
    $anggota['bagi-hasil'] = $_POST['bagi-hasil'];
    $anggota['ujrah'] = $_POST['ujrah'];

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
        pembayaran_pinjam_insert_data($anggota);
        $success = true;
    }

    if ($success) {
      redirect_to(url_for('/pembukuan_masuk/pembayaran_pinjam/create.php'));
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
          <form enctype="multipart/form-data" method="post" action="<?php echo url_for('/pembukuan_masuk/pembayaran_pinjam/input.php'); ?>">
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
                Anggota Belum Terdaftar Silahkan Cek Kembali Nomor Anggota
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Nama Anggota</label>
              <input class="form-control" type="text" placeholder="Input Nama" aria-label="" name="nama" id="input_nama_anggota" value="<?php echo $anggota['nama']; ?>" required disabled>
            </div>
            <div class="mb-3">
              <label class="form-label">Pembayaran Bulan</label>
              <select class="form-select" name="pembayaran-bulan" id="input_pembayaran_bulan">
                <option value="<?php echo date('Y-01-d'); ?>" <?php echo $m_selected['01']; ?>>January</option>
                <option value="<?php echo date('Y-02-d'); ?>" <?php echo $m_selected['02']; ?>>February</option>
                <option value="<?php echo date('Y-03-d'); ?>" <?php echo $m_selected['03']; ?>>March</option>
                <option value="<?php echo date('Y-04-d'); ?>" <?php echo $m_selected['04']; ?>>April</option>
                <option value="<?php echo date('Y-05-d'); ?>" <?php echo $m_selected['05']; ?>>May</option>
                <option value="<?php echo date('Y-06-d'); ?>" <?php echo $m_selected['06']; ?>>June</option>
                <option value="<?php echo date('Y-07-d'); ?>" <?php echo $m_selected['07']; ?>>July</option>
                <option value="<?php echo date('Y-08-d'); ?>" <?php echo $m_selected['08']; ?>>August</option>
                <option value="<?php echo date('Y-09-d'); ?>" <?php echo $m_selected['09']; ?>>September</option>
                <option value="<?php echo date('Y-10-d'); ?>" <?php echo $m_selected['10']; ?>>October</option>
                <option value="<?php echo date('Y-11-d'); ?>" <?php echo $m_selected['11']; ?>>November</option>
                <option value="<?php echo date('Y-12-d'); ?>" <?php echo $m_selected['12']; ?>>Desember</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Pokok Pinjaman</label>
              <input class="form-control <?php if (isset($error['error_input_pokok_pinjaman'])) {
                echo $invalid;
              } else {
                echo $valid;
              } ?>" type="number" placeholder="Input Pokok Pinjaman" aria-label="" name="pokok-pinjaman" id="input_pokok_pinjaman" value="<?php echo $anggota['pokok-pinjaman']; ?>" required>
              <div id="input_pokok_pinjaman_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_pokok_pinjaman_feedback" class="invalid-feedback">
                Please Fill This
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Bagi Hasil</label>
              <input class="form-control <?php if (isset($error['error_input_bagi_hasil'])) {
                echo $invalid;
              } else {
                echo $valid;
              } ?>" type="number" placeholder="Input Bagi Hasil" aria-label="" name="bagi-hasil" id="input_bagi_hasil" value="<?php echo $anggota['bagi-hasil']; ?>" required>
              <div id="input_bagi_hasil_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_bagi_hasil_feedback" class="invalid-feedback">
                Please Fill This
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Ujrah</label>
              <input class="form-control <?php if (isset($error['error_input_ujrah'])) {
                echo $invalid;
              } else {
                echo $valid;
              } ?>" type="number" placeholder="Input Ujrah" aria-label="" name="ujrah" id="input_ujrah" value="<?php echo $anggota['ujrah']; ?>" required>
              <div id="input_ujrah_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_ujrah_feedback" class="invalid-feedback">
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

      <script type="text/javascript" src="<?php echo url_for('/js/pembayaran_pinjam.js'); ?>"></script>

<?php include(SHARED_PATH . '/app_footer.php'); ?>
