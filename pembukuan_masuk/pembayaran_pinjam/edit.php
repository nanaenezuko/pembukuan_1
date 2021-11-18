<?php
  require_once('../../private/initialize.php');

  $id = $_GET['id'];
  $invalid = "is-invalid";
  $valid = "is-valid";
  $validate = true;
  $check = [];
  $error = [];
  $m_selected = ['01' => '','02' => '','03' => '','04' => '','05' => '',
                '06' => '','07' => '','08' => '','09' => '','10' => '',
                '11' => '', '12' => ''];

  include(SHARED_PATH . '/app_header.php');
  is_admin("pembukuan_masuk/pembayaran_pinjam");

  if (is_post_request() && $id !== "") {
    $anggota['pembayaran-bulan'] = $_POST['pembayaran-bulan'];
    $anggota['pokok-pinjaman'] = $_POST['pokok-pinjaman'];
    $anggota['ujrah'] = $_POST['ujrah'];
    $anggota['pokok-pinjaman'] = $_POST['pokok-pinjaman'];
    $anggota['bagi-hasil'] = $_POST['bagi-hasil'];
    $result = pembayaran_pinjam_update_data($id, $anggota);
  }

  if ($id !== "") {
    $data = pembayaran_pinjam_find_one($_GET['id']);
    $m_selected[substr($data['pembayaran_bulan'], 5, 2)] = 'selected';
    if (isset($data)) {
      $page_title = "Edit Data";
      $breadcumb_name = ['Pembukuan Masuk','Pembayaran Pinjam','Edit'];
      $breadcumb_link = ['pembukuan_masuk','pembukuan_masuk/pembayaran_pinjam/',
      '/pembukuan_masuk/pembayaran_pinjam/edit.php'];
    } else {
      redirect_to(url_for('/pembukuan_masuk/pembayaran_pinjam/'));
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
          <form enctype="multipart/form-data" method="post" action="<?php echo url_for('/pembukuan_masuk/pembayaran_pinjam/edit.php?id='.$id); ?>">
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
              } ?>" type="number" placeholder="Input Simpanan Pajak" aria-label="" name="pokok-pinjaman" id="input_pokok_pinjaman" value="<?php echo $data['pokok_pinjaman']; ?>" required>
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
              } ?>" type="number" placeholder="Input Simpanan Wajib" aria-label="" name="bagi-hasil" id="input_bagi_hasil" value="<?php echo $data['bagi_hasil']; ?>" required>
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
              } ?>" type="number" placeholder="Input Simpanan Sukarela" aria-label="" name="ujrah" id="input_ujrah" value="<?php echo $data['ujrah']; ?>" required>
              <div id="input_ujrah_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_ujrah_feedback" class="invalid-feedback">
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


      <script type="text/javascript" src="<?php echo url_for('/js/pembayaran_pinjam.js'); ?>"></script>
<?php include(SHARED_PATH . '/app_footer.php'); ?>
