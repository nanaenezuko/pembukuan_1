<?php
  require_once('../../private/initialize.php');

  $target_dir = PUBLIC_PATH. '/uploads/keanggotaan/anggota_keluar/';
  $page_title = "Input Anggota Keluar";
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
  $image_file_type = [];

  $anggota['no-urut'] = '';
  $anggota['nama'] = '';
  $anggota['jumlah-simpanan'] = '';

  $page_title_data = "Anggota Keluar";
  $breadcumb_name = ['Keanggotaan','Anggota Keluar','Input'];
  $breadcumb_link = ['keanggotaan','/keanggotaan/anggota_keluar/',
  '/keanggotaan/anggota_keluar/input.php'];
  include(SHARED_PATH . '/app_header.php');
  is_admin("keanggotaan/anggota_keluar");

  if (is_post_request()) {
    $valid = "is-valid";
    $invalid = "is-invalid";
    $upload_invalid = "- Maaf, Hanya file JPG, JPEG, PNG & GIF yang bisa diupload <br> - Ukuran File maksimal 5MB";
    $upload_kembali = "Mohon diupload Kembali";

    $anggota['no-urut'] = $_POST['no-urut'];
    $anggota['jumlah-simpanan'] = $_POST['jumlah-simpanan'];

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
    $file_name = [$anggota['no-urut']."-form",
      $anggota['no-urut']."-bukti-kirim"];
    //FILE ASSIGN
    $file_upload = [$_FILES["file-form"],
      $_FILES["file-bukti-kirim"]];

    if (!file_exists($target_dir. $anggota['no-urut']."/")) {
      mkdir($target_dir.$anggota['no-urut']."/");
    }

    $target_dir .= $anggota['no-urut']."/";

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
        $anggota['file-form'] = $file_link[0];
        $anggota['file-bukti-bayar'] = $file_link[1];

        anggota_keluar_insert_data($anggota);
        rekap_anggota_update_data($anggota['no-urut'], "tidak aktif");
        $success = true;
      }

      if ($success) {
        redirect_to(url_for('/keanggotaan/anggota_keluar/create.php'));
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
          <form enctype="multipart/form-data" method="post" action="<?php echo url_for('/keanggotaan/anggota_keluar/input.php'); ?>">
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
              <label class="form-label">Jumlah Simpanan</label>
              <input class="form-control <?php echo $valid; ?>" type="number" placeholder="Input Jumlah Simpanan" aria-label="" name="jumlah-simpanan" id="input_jumlah_simpanan" value="<?php echo $anggota['jumlah-simpanan']; ?>" required>
              <div id="input_jumlah_simpanan_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_jumlah_simpanan_feedback" class="invalid-feedback">
                Please fill this
              </div>
            </div>
            <div class="mb-3">
              <label  class="form-label">Upload Form</label>
              <input class="form-control <?php echo $invalid; ?>" type="file" name="file-form" id="input_file_form" required>
              <div id="input_form_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_form_feedback" class="invalid-feedback">
                <?php if (isset($error['file_upload_0'])) {
                  echo $upload_invalid;
                } else {
                  echo $upload_kembali;
                } ?>
              </div>
            </div>
            <div class="mb-3">
              <label  class="form-label">Upload Bukti Kirim</label>
              <input class="form-control <?php echo $invalid; ?>" type="file" name="file-bukti-kirim" id="input_file_bukti_kirim" required>
              <div id="input_file_bukti_kirim_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_file_bukti_kirim_feedback" class="invalid-feedback">
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

      <script type="text/javascript" src="<?php echo url_for('/js/anggota_keluar.js'); ?>"></script>

<?php include(SHARED_PATH . '/app_footer.php'); ?>
