<?php
  require_once('../../private/initialize.php');

  $target_dir = PUBLIC_PATH. '/uploads/pembukuan_keluar/pembayaran_pinjaman_anggota/';
  $page_title = "Input Pembayaran Pinjaman Anggota";
  $validate = true;
  $success = false;
  $invalid = "";
  $valid = "";
  $upload_invalid = "";
  $upload_kembali = "";
  $error = [];
  $file_upload = [];
  $file_link = [];
  $file_name = [];
  $check = [];
  $upload_ok = 1;
  $folder = 0;
  $image_file_type = [];

  $anggota['no-urut'] = '';
  $anggota['nama'] = '';
  $anggota['kode-transaksi'] = '';
  $anggota['lama-pinjaman'] = '';
  $anggota['jumlah-pinjaman'] = '';

  $page_title_data = "Pembayaran Pinjaman Anggota";
  $breadcumb_name = ['Pembukuan Keluar','Pembayaran Pinjaman Anggota','Input'];
  $breadcumb_link = ['pembukuan_keluar','/pembukuan_keluar/pembayaran_pinjaman_anggota/',
  '/pembukuan_keluar/pembayaran_pinjaman_anggota/input.php'];
  include(SHARED_PATH . '/app_header.php');
  is_admin("pembukuan_keluar/pembayaran_pinjaman_anggota");

  if (is_post_request()) {
    $valid = "is-valid";
    $invalid = "is-invalid";
    $upload_invalid = "- Maaf, Hanya file JPG, JPEG, PNG & GIF yang bisa diupload <br> - Ukuran File maksimal 5MB";
    $upload_kembali = "Mohon diupload Kembali";

    $anggota['no-urut'] = $_POST['no-urut'];
    $anggota['kode-transaksi'] = $_POST['kode-transaksi'];
    $anggota['lama-pinjaman'] = $_POST['lama-pinjaman'];
    $anggota['jumlah-pinjaman'] = $_POST['jumlah-pinjaman'];

    //Check Database IF Exists
    $data = anggota_masuk_find_one($anggota['no-urut']);
    $data2 = anggota_keluar_find_one($anggota['no-urut']);
    if (!isset($data) || isset($data2)) {
      $error['error_input_no_anggota'] = 1;
      $validate = false;
    }

    if (isset($data)) {
      $anggota['nama'] = $data['nama_anggota'];
    }

    //FILE NAMING
    $file_name = [$anggota['no-urut']."-formulir",
      $anggota['no-urut']."-bukti-bayar"];
    //FILE ASSIGN
    $file_upload = [$_FILES["file-formulir"],
      $_FILES["file-bukti-bayar"]];

    if (!file_exists($target_dir.$anggota['no-urut']."/")) {
      mkdir($target_dir.$anggota['no-urut']."/");
    }

    $folder_i = 1;
    do {
      if (!file_exists($target_dir.$anggota['no-urut']."/".$folder_i."/*")) {
        if (!file_exists($target_dir.$anggota['no-urut']."/".$folder_i."/")) {
          mkdir($target_dir.$anggota['no-urut']."/".$folder_i."/");
          $target_dir .= $anggota['no-urut']."/".$folder_i."/";
          $anggota['folder'] = $folder_i;
          $folder = 1;
        }
      }
      $folder_i++;
    } while ($folder == 0);

    for ($i=0; $i < sizeof($file_upload) ; $i++) {
      $image_file_type[$i] = strtolower(pathinfo($target_dir . basename($file_upload[$i]["name"]), PATHINFO_EXTENSION));
      $check[$i] = getimagesize($file_upload[$i]["tmp_name"]);
      if ($check[$i] !== null && $check[$i] !== false) {

        //Limit File Size
        if ($file_upload[$i]["size"] > 5000000) {
          $error['file_upload_'.$i] = 1;
          $validate = false;
          $upload_ok = 0;

        }
        //Check if Image Format
        if ($image_file_type[$i] != "jpg" && $image_file_type[$i] != "png" && $image_file_type[$i] != "jpeg" &&
          $image_file_type[$i] != "gif") {
            $error['file_upload_'.$i] = 1;
            $validate = false;
            $upload_ok = 0;
        }

      } else {
        $error['file_upload_'.$i] = 1;
        $validate = false;
        $upload_ok = 0;
      }
    }


    if ($validate) {

      for ($i=0; $i < sizeof($file_upload) ; $i++) {
        if ($upload_ok == 0) {
          echo "Sorry Your files is not uploaded";
        } else {
          if (move_uploaded_file($file_upload[$i]["tmp_name"], $target_dir.$file_name[$i].".".$image_file_type[$i])) {
            //echo "<br>The File ". h(basename($file_upload[$i]['name'])). "Has been uploaded";
            $file_link[$i] = $file_name[$i].".".$image_file_type[$i];
          } else {
            echo "<br>Sorry there was an error for uploading your files";
            $upload_ok = 0;
          }
        }
      }

      if ($upload_ok !== 0) {
        //Assign File Link
        $anggota['file-formulir'] = $file_link[0];
        $anggota['file-bukti-bayar'] = $file_link[1];

        pembayaran_pinjaman_anggota_insert_data($anggota);
        $success = true;
      }

      if ($success) {
        redirect_to(url_for('/pembukuan_keluar/pembayaran_pinjaman_anggota/create.php'));
        exit;
      }
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
          <form enctype="multipart/form-data" method="post" action="<?php echo url_for('/pembukuan_keluar/pembayaran_pinjaman_anggota/input.php'); ?>">
            <div class="mb-3">
              <label class="form-label">Tanggal</label>
              <input class="form-control <?php echo $valid; ?>" type="date" aria-label="" name="tanggal" id="input_tanggal" value="<?php echo date('Y-m-d'); ?>" required disabled>
            </div>
            <div class="mb-3">
              <label class="form-label">Kode Transaksi</label>
              <input class="form-control <?php if (isset($error['error_input_kode_transaksi'])) {
                echo $invalid;
              } else {
                echo $valid;
              } ?>" type="text" placeholder="Input Kode Transaksi" aria-label="" name="kode-transaksi" id="input_kode_transaksi" value="<?php echo $anggota['kode-transaksi']; ?>" required>
              <div id="input_kode_transaksi_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_kode_transaksi_feedback" class="invalid-feedback">
                please Fill This
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">No Urut Anggota</label>
              <input class="form-control <?php if (isset($error['error_input_no_anggota'])) {
                echo $invalid;
              } else {
                echo $valid;
              } ?>" type="text" placeholder="Input No Anggota" aria-label="" name="no-urut" id="input_no_anggota" value="<?php echo $anggota['no-urut']; ?>" required>
              <div id="input_no_anggota_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_no_anggota_feedback" class="invalid-feedback">
                Nomor Anggota Belum Terdaftar atau Sudah keluar Silahkan cek kembali
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Nama Anggota</label>
              <input class="form-control <?php echo $valid; ?>" type="text" placeholder="Input Nama" aria-label="" name="nama" id="input_nama_anggota" value="<?php echo $anggota['nama']; ?>" disabled required>
              <div id="input_nama_anggota_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_nama_anggota_feedback" class="invalid-feedback">
                Please Fill This
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Lama Pinjaman</label>
              <input class="form-control <?php echo $valid; ?>" type="text" placeholder="Input Lama Pinjaman" aria-label="" name="lama-pinjaman" id="input_lama_pinjaman" value="<?php echo $anggota['lama-pinjaman']; ?>" required>
              <div id="input_lama_pinjaman_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_lama_pinjaman_feedback" class="invalid-feedback">
                Please fill this
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Jumlah Pinjaman</label>
              <input class="form-control <?php echo $valid; ?>" type="number" placeholder="Input Jumlah Pinjaman" aria-label="" name="jumlah-pinjaman" id="input_jumlah_pinjaman" value="<?php echo $anggota['jumlah-pinjaman']; ?>" required>
              <div id="input_jumlah_pinjaman_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_jumlah_pinjaman_feedback" class="invalid-feedback">
                Please fill this
              </div>
            </div>
            <div class="mb-3">
              <label  class="form-label">Upload Formulir</label>
              <input class="form-control <?php echo $invalid; ?>" type="file" name="file-formulir" id="input_file_formulir" required>
              <div id="input_formulir_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_formulir_feedback" class="invalid-feedback">
                <?php if (isset($error['file_upload_0'])) {
                  echo $upload_invalid;
                } else {
                  echo $upload_kembali;
                } ?>
              </div>
            </div>
            <div class="mb-3">
              <label  class="form-label">Upload Bukti Bayar</label>
              <input class="form-control <?php echo $invalid; ?>" type="file" name="file-bukti-bayar" id="input_file_bukti_bayar" required>
              <div id="input_file_bukti_bayar_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_file_bukti_bayar_feedback" class="invalid-feedback">
                <?php if (isset($error['file_upload_1'])) {
                  echo $upload_invalid;
                } else {
                  echo $upload_kembali;
                } ?>
              </div>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <button class="btn btn-outline-primary me-md-2" type="button" id="btn_cancel_delete">Cancel</button>
              <input type="submit" name="submit" value="Submit" class="btn btn-primary text-white" id="submit_create">
            </div>
          </form>
        </div>
      </div>

      <script type="text/javascript" src="<?php echo url_for('/js/pembayaran_pinjaman_anggota.js'); ?>"></script>

<?php include(SHARED_PATH . '/app_footer.php'); ?>
