<?php
  require_once('../../private/initialize.php');

  $target_dir = PUBLIC_PATH. '/uploads/keanggotaan/anggota_masuk/';
  $page_title = "Input Anggota Masuk";
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

  $no_anggota = generate_no_anggota();

  $anggota['no-urut'] = '';
  $anggota['nama'] = '';
  $anggota['nik'] = '';
  $anggota['no-npwp'] = '';
  $anggota['tanggal-lahir'] = date('Y-m-d');
  $anggota['agama'] = '';
  $anggota['jenis-kelamin'] = '';
  $anggota['unit'] = '';
  $anggota['alamat'] = '';

  $page_title_data = "Anggota Masuk";
  $breadcumb_name = ['Keanggotaan','Anggota Masuk','Input'];
  $breadcumb_link = ['keanggotaan','/keanggotaan/anggota_masuk/',
  '/keanggotaan/anggota_masuk/input.php'];
  include(SHARED_PATH . '/app_header.php');
  is_admin("keanggotaan/anggota_masuk");

  if (is_post_request()) {
    $valid = "is-valid";
    $invalid = "is-invalid";
    $upload_invalid = "- Maaf, Hanya file JPG, JPEG, PNG & GIF yang bisa diupload <br> - Ukuran File maksimal 5MB";
    $upload_kembali = "Mohon diupload Kembali";

    $anggota['no-urut'] = $no_anggota;
    $anggota['nama'] = $_POST['nama'];
    $anggota['nik'] = $_POST['nik'];
    $anggota['no-npwp'] = $_POST['no-npwp'];
    $anggota['tanggal-lahir'] = $_POST['tanggal-lahir'];
    $anggota['agama'] = $_POST['agama'];
    $anggota['jenis-kelamin'] = $_POST['jenis-kelamin'];
    $anggota['unit'] = $_POST['unit'];
    $anggota['alamat'] = $_POST['alamat'];

    if (!has_length_exactly($anggota['nik'], 16)) {
      $error['error_input_nik'] = 1;
      $validate = false;
    }

    if (has_length_less_than($anggota['no-npwp'], 15)) {
      $error['error_input_npwp'] = 1;
      $validate = false;
    }

    $data = anggota_masuk_find_one($anggota['no-urut']);
    if (isset($data)) {
      $error['error_input_no_anggota'] = 1;
      $validate = false;
    }

    //FILE NAMING
    $file_name = [$anggota['no-urut']."-ktp",
      $anggota['no-urut']."-npwp",
      $anggota['no-urut']."-foto",
      $anggota['no-urut']."-formulir"];
    //FILE ASSIGN
    $file_upload = [$_FILES["file-ktp"],
      $_FILES["file-npwp"],
      $_FILES["file-foto"],
      $_FILES["file-formulir"]];

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
        $anggota['file-ktp'] = $file_link[0];
        $anggota['file-npwp'] = $file_link[1];
        $anggota['file-foto'] = $file_link[2];
        $anggota['file-formulir'] = $file_link[3];

        anggota_masuk_insert_data($anggota);
        rekap_anggota_insert_data($anggota, "aktif");
        $success = true;
      }

      if ($success) {
        redirect_to(url_for('/keanggotaan/anggota_masuk/create.php'));
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
          <form enctype="multipart/form-data" method="post" action="<?php echo url_for('/keanggotaan/anggota_masuk/input.php'); ?>">
            <div class="mb-3">
              <label class="form-label">No Urut Anggota</label>
              <input class="form-control <?php if (isset($error['error_input_no_anggota'])) {
                echo $invalid;
              } else {
                echo $valid;
              } ?>" type="text" placeholder="Input Nomor" aria-label="" name="no-urut" id="input_no_anggota" value="<?php echo $no_anggota; ?>" disabled readonly>
              <div id="input_no_anggota_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_no_anggota_feedback" class="invalid-feedback">
                Please Fill This atau data sudah ada, Silahkan ulangi kembali dari menu input
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Nama Anggota</label>
              <input class="form-control <?php echo $valid; ?>" type="text" placeholder="Input Nama" aria-label="" name="nama" id="input_nama_anggota" value="<?php echo $anggota['nama']; ?>" required>
              <div id="input_nama_anggota_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_nama_anggota_feedback" class="invalid-feedback">
                Please Fill This
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">NIK Anggota</label>
              <input class="form-control <?php if (isset($error['error_input_nik'])) {
                echo $invalid;
              } else {
                echo $valid;
              } ?>" type="number" placeholder="Input NIK" aria-label="" name="nik" id="input_nik" value="<?php echo $anggota['nik']; ?>" required>
              <div id="input_nik_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_nik_feedback" class="invalid-feedback">
                NIK KTP sebanyak 16 Digit
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">No NPWP</label>
              <input class="form-control <?php if (isset($error['error_input_npwp'])) {
                echo $invalid;
              } else {
                echo $valid;
              }?>" type="text" placeholder="Input No NPWP" aria-label="" name="no-npwp" id="input_npwp" value="<?php echo $anggota['no-npwp']; ?>" required>
              <div id="input_npwp_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_npwp_feedback" class="invalid-feedback">
                NO NPWP Sebanyak 15 Digit
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Tanggal Lahir</label>
              <input class="form-control <?php echo $valid; ?>" type="date" aria-label="" name="tanggal-lahir" id="input_tanggal_lahir" value="<?php echo $anggota['tanggal-lahir']; ?>" required>
              <div id="input_tanggal_lahir_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_tanggal_lahir_feedback" class="invalid-feedback">
                Please Fill This
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Agama</label>
              <input class="form-control <?php echo $valid; ?>" list="datalistAgamaOptions" name="agama" id="input_agama" placeholder="Input Agama" value="<?php echo $anggota['agama']; ?>" required>
              <datalist id="datalistAgamaOptions">
                <option value="Islam">
                <option value="Katholik">
                <option value="Protestan">
                <option value="Hindu">
                <option value="Buddha">
                <option value="Kong Hu Chu">
              </datalist>
              <div id="input_agama_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_agama_feedback" class="invalid-feedback">
                Please Fill This
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Jenis Kelamin</label>
              <select class="form-select <?php echo $valid; ?>" aria-label="Default select example" name="jenis-kelamin" required>
                <option value="l" <?php if ($anggota['jenis-kelamin'] == 'l' || $anggota['jenis-kelamin'] == "") {
                  echo "selected";
                } ?>>Laki - Laki</option>
                <option value="p" <?php if ($anggota['jenis-kelamin'] == 'p') {
                  echo "selected";
                } ?>>Perempuan</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Unit</label>
              <input class="form-control <?php echo $valid; ?>" type="text" placeholder="Input Unit" aria-label="" name="unit" id="input_unit" value="<?php echo $anggota['unit']; ?>" required>
              <div id="input_unit_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_unit_feedback" class="invalid-feedback">
                Please Fill This
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Alamat</label>
              <textarea class="form-control <?php echo $valid; ?>" rows="4" name="alamat" id="input_alamat" value="" required><?php echo $anggota['alamat']; ?></textarea>
              <div id="input_alamat_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_alamat_feedback" class="invalid-feedback">
                Please Fill This
              </div>
            </div>
            <div class="mb-3">
              <label  class="form-label">Upload KTP</label>
              <input class="form-control <?php echo $invalid; ?>" type="file" name="file-ktp" id="input_file_ktp" required>
              <div id="input_file_ktp_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_file_ktp_feedback" class="invalid-feedback">
                <?php if (isset($error['file_upload_0'])) {
                  echo $upload_invalid;
                } else {
                  echo $upload_kembali;
                } ?>
              </div>
            </div>
            <div class="mb-3">
              <label  class="form-label">Upload NPWP</label>
              <input class="form-control <?php echo $invalid; ?>" type="file" name="file-npwp" id="input_file_npwp" required>
              <div id="input_file_npwp_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_file_npwp_feedback" class="invalid-feedback">
                <?php if (isset($error['file_upload_1'])) {
                  echo $upload_invalid;
                } else {
                  echo $upload_kembali;
                } ?>
              </div>
            </div>
            <div class="mb-3">
              <label  class="form-label">Upload Foto</label>
              <input class="form-control <?php echo $invalid; ?>" type="file" name="file-foto" id="input_file_foto" required>
              <div id="input_file_foto_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_file_foto_feedback" class="invalid-feedback">
                <?php if (isset($error['file_upload_2'])) {
                  echo $upload_invalid;
                } else {
                  echo $upload_kembali;
                } ?>
              </div>
            </div>
            <div class="mb-3">
              <label  class="form-label">Upload Formulir</label>
              <input class="form-control <?php echo $invalid; ?>" type="file" name="file-formulir" id="input_file_formulir" required>
              <div id="input_file_formulir_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_file_formulir_feedback" class="invalid-feedback">
                <?php if (isset($error['file_upload_3'])) {
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

      <script type="text/javascript" src="<?php echo url_for('/js/anggota_masuk.js'); ?>"></script>

<?php include(SHARED_PATH . '/app_footer.php'); ?>
