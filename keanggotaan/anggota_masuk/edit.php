<?php
  require_once('../../private/initialize.php');

  $id = $_GET['id'];
  $target_dir = PUBLIC_PATH. '/uploads/keanggotaan/anggota_masuk/';
  $invalid = "is-invalid";
  $valid = "is-valid";
  $upload_invalid = "";
  $upload_kembali = "";
  $upload_invalid = "- Maaf, Hanya file JPG, JPEG, PNG & GIF yang bisa diupload <br> - Ukuran File maksimal 5MB";
  $upload_ok = 1;
  $validate = true;
  $check = [];
  $file_upload = [];
  $error = [];

  include(SHARED_PATH . '/app_header.php');
  is_admin("keanggotaan/anggota_masuk");

  if (is_post_request() && $id !== "") {
    $data = anggota_masuk_find_one($_GET['id']);

    $result = anggota_masuk_update($id);

    $file_name = [$data['no_anggota']."-ktp",
      $data['no_anggota']."-npwp",
      $data['no_anggota']."-foto",
      $data['no_anggota']."-formulir"];

    $file_upload = [$_FILES["file-ktp"],
      $_FILES["file-npwp"],
      $_FILES["file-foto"],
      $_FILES["file-formulir"]];

    $target_dir .= $data['no_anggota']."/";

    for ($i=0; $i < sizeof($file_upload) ; $i++) {
      if ($file_upload[$i]['name'] !== "") {
        $image_file_type[$i] = strtolower(pathinfo($target_dir . basename($file_upload[$i]["name"]), PATHINFO_EXTENSION));
        $check[$i] = getimagesize($file_upload[$i]["tmp_name"]);
        if ($check[$i] !== null && $check[$i] !== false) {
          //echo "<br>File $i is Image". $check[$i]["mime"];

          //Limit File Size
          if ($file_upload[$i]["size"] > 5000000) {
            $error['file_upload_'.$i] = 1;
            $upload_ok = 0;

          }
          //Check if Image Format
          if ($image_file_type[$i] != "jpg" && $image_file_type[$i] != "png" && $image_file_type[$i] != "jpeg" &&
            $image_file_type[$i] != "gif") {
              $error['file_upload_'.$i] = 1;
              $upload_ok = 0;
          }

        } else {
          $error['file_upload_'.$i] = 1;
          $upload_ok = 0;
          //echo "<br>File $i is not Image";
          //redirect_to(url_for('/keanggotaan/anggota_masuk.php'));
        }
      }
    }
    if ($validate) {
      for ($i=0; $i < sizeof($file_upload) ; $i++){
        if ($upload_ok == 0 && !$file_upload[$i]['name'] !== "") {
          //echo "Sorry Your files is not uploaded";
        } else {
          if ($file_upload[$i]['name'] !== ""){
            if (move_uploaded_file($file_upload[$i]["tmp_name"], $target_dir.$file_name[$i].".".$image_file_type[$i])) {
              //echo "<br>The File ". h(basename($file_upload[$i]['name'])). "Has been uploaded";
              //$file_link[$i] = $file_name[$i].".".$image_file_type[$i];
              $file = substr($file_name[$i],strlen($data['no_anggota']) + 1);
              $sql = "UPDATE anggota_masuk SET link_".$file." = '".$file_name[$i].".".$image_file_type[$i]."' ";
              $sql .= "WHERE no_anggota = '".$data['no_anggota']."' LIMIT 1";
              $result = mysqli_query($db, $sql);
            } else {
              echo "<br>Sorry there was an error for uploading your files";
              $upload_ok = 0;
            }
          }
        }
      }
    }
  }

  if ($id !== "") {
    $data = anggota_masuk_find_one($_GET['id']);
    if (isset($data)) {
      $file_dir = "/uploads/keanggotaan/anggota_masuk/".$data['no_anggota']."/";
      $page_title = "Edit Data";
      $breadcumb_name = ['Keanggotaan','Anggota Masuk','Edit'];
      $breadcumb_link = ['keanggotaan','keanggotaan/anggota_masuk/',
      '/keanggotaan/anggota_masuk/edit.php'];
    } else {
      redirect_to(url_for('/keanggotaan/anggota_masuk/'));
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
          <form enctype="multipart/form-data" method="post" action="<?php echo url_for('/keanggotaan/anggota_masuk/edit.php?id='.$id); ?>">
            <div class="mb-3">
              <label class="form-label">No Urut Anggota</label>
              <input class="form-control" type="text" placeholder="Input Nomor" aria-label="" name="no-urut" value="<?php echo $data['no_anggota']; ?>" disabled readonly>
            </div>
            <div class="mb-3">
              <label class="form-label">Nama Anggota</label>
              <input id="input_nama_anggota" class="form-control <?php echo $valid; ?>" type="text" placeholder="Input Nama" aria-label="" name="nama" value="<?php echo $data['nama_anggota']; ?>" required>
              <div id="input_nama_anggota_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_nama_anggota_feedback" class="invalid-feedback">
                Please Fill This
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">NIK Anggota</label>
              <input id="input_nik" class="form-control <?php echo $valid ?>" type="number" placeholder="Input NIK" aria-label="" name="nik" value="<?php echo $data['nik']; ?>" required>
              <div id="input_nik_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_nik_feedback" class="invalid-feedback">
                NIK KTP sebanyak 16 Digit
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">No NPWP</label>
              <input id="input_npwp" class="form-control <?php echo $valid; ?>" type="text" placeholder="Input No NPWP" aria-label="" name="no-npwp" value="<?php echo $data['no_npwp']; ?>" required>
              <div id="input_npwp_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_npwp_feedback" class="invalid-feedback">
                NO NPWP sebanyak 15 Digit
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Tanggal Lahir</label>
              <input id="input_tanggal_lahir" class="form-control <?php echo $valid; ?>" type="date" aria-label="" name="tanggal-lahir" value="<?php echo $data['tanggal_lahir']; ?>" required>
              <div id="input_tanggal_lahir_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_tanggal_lahir_feedback" class="invalid-feedback">
                Please Fill This
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Agama</label>
              <input id="input_agama" class="form-control <?php echo $valid; ?>" type="text" placeholder="Input Agama" aria-label="" name="agama" value="<?php echo $data['agama']; ?>" required>
              <div id="input_agama_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_agama_feedback" class="invalid-feedback">
                Please Fill This
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Jenis Kelamin</label>
              <select class="form-select <?php echo $valid; ?>" aria-label="Default select example" name="jenis-kelamin">
                <option value="l" <?php if ($data['jenis_kelamin'] == 'l') {
                  echo "selected";
                } ?>>Laki - Laki</option>
                <option value="p" <?php if ($data['jenis_kelamin'] == 'p') {
                  echo "selected";
                } ?>>Perempuan</option>
              </select>
              <div id="input_jk_feedback" class="valid-feedback">
                Good
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Unit</label>
              <input id="input_unit" class="form-control <?php echo $valid; ?>" type="text" placeholder="Input Unit" aria-label="" name="unit" value="<?php echo $data['unit']; ?>" required>
              <div id="input_unit_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_unit_feedback" class="invalid-feedback">
                Please Fill This
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Alamat</label>
              <textarea id="input_alamat" class="form-control <?php echo $valid ?>" rows="4" name="alamat" required><?php echo $data['alamat']; ?></textarea>
              <div id="input_alamat_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_alamat_feedback" class="invalid-feedback">
                Please Fill This
              </div>
            </div>
            <div class="mb-3">
              <div class="row">
                <div class="col-8">
                  <label  class="form-label">Upload KTP</label>
                </div>
                <div class="col-4">
                  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button id="btn-edit-ktp" class="btn btn-outline-primary btn-edit-file" type="button" onclick="EditFile('btn-edit-ktp','btn-file-ktp','file-ktp')">Edit</button>
                  </div>
                </div>
              </div>
              <div class="d-grid gap-2">
                <button id="btn-file-ktp" class="btn btn-outline-primary" type="button" onclick="location.href = '<?php echo url_for($file_dir.$data['link_ktp']); ?>';" <?php if (isset($error['file_upload_0'])) {
                  echo "hidden";
                } ?>>FILE KTP</button>
              </div>
              <div id="file-ktp" class="" <?php if (!isset($error['file_upload_0'])) {
                echo "hidden";
              } ?>>
                <input class="form-control <?php if (isset($error['file_upload_0'])) {
                  echo $invalid;
                } ?>" type="file" name="file-ktp" value="<?php echo $data['link_ktp']; ?>">
                <div id="input_file_ktp_feedback" class="valid-feedback">
                  Good
                </div>
                <div id="input_file_ktp_feedback" class="invalid-feedback">
                  <?php echo $upload_invalid; ?>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <div class="row">
                <div class="col-8">
                  <label  class="form-label">Upload NPWP</label>
                </div>
                <div class="col-4">
                  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button id="btn-edit-npwp" class="btn btn-outline-primary btn-edit-file" type="button" onclick="EditFile('btn-edit-npwp','btn-file-npwp','file-npwp')">Edit</button>
                  </div>
                </div>
              </div>
              <div class="d-grid gap-2">
                <button id="btn-file-npwp" class="btn btn-outline-primary" type="button" onclick="location.href = '<?php echo url_for($file_dir.$data['link_npwp']); ?>';" <?php if (isset($error['file_upload_1'])) {
                  echo "hidden";
                } ?>>FILE NPWP</button>
              </div>
              <div id="file-npwp" class="" <?php if (!isset($error['file_upload_1'])) {
                echo "hidden";
              } ?>>
                <input class="form-control <?php if (isset($error['file_upload_1'])) {
                  echo $invalid;
                } ?>" type="file" name="file-npwp" value="<?php echo $data['link_npwp']; ?>">
                <div id="input_file_npwp_feedback" class="valid-feedback">
                  Good
                </div>
                <div id="input_file_npwp_feedback" class="invalid-feedback">
                  <?php echo $upload_invalid; ?>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <div class="row">
                <div class="col-8">
                  <label  class="form-label">Upload Foto</label>
                </div>
                <div class="col-4">
                  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button id="btn-edit-foto" class="btn btn-outline-primary btn-edit-file" type="button" onclick="EditFile('btn-edit-foto','btn-file-foto','file-foto')">Edit</button>
                  </div>
                </div>
              </div>
              <div class="d-grid gap-2">
                <button id="btn-file-foto" class="btn btn-outline-primary" type="button" onclick="location.href = '<?php echo url_for($file_dir.$data['link_foto']); ?>';" <?php if (isset($error['file_upload_2'])) {
                  echo "hidden";
                } ?>>FILE FOTO</button>
              </div>
              <div id="file-foto" class="" <?php if (!isset($error['file_upload_2'])) {
                echo "hidden";
              } ?>>
                <input class="form-control <?php if (isset($error['file_upload_2'])) {
                  echo $invalid;
                } ?>" type="file" name="file-foto" value="<?php echo $data['link_foto']; ?>">
                <div id="input_file_foto_feedback" class="valid-feedback">
                  Good
                </div>
                <div id="input_file_foto_feedback" class="invalid-feedback">
                  <?php echo $upload_invalid; ?>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <div class="row">
                <div class="col-8">
                  <label  class="form-label">Upload Formulir</label>
                </div>
                <div class="col-4">
                  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button id="btn-edit-formulir" class="btn btn-outline-primary btn-edit-file" type="button" onclick="EditFile('btn-edit-formulir','btn-file-formulir','file-formulir')">Edit</button>
                  </div>
                </div>
              </div>
              <div class="d-grid gap-2">
                <button id="btn-file-formulir" class="btn btn-outline-primary" type="button" onclick="location.href = '<?php echo url_for($file_dir.$data['link_formulir']); ?>';" <?php if (isset($error['file_upload_3'])) {
                  echo "hidden";
                } ?>>FILE FORMULIR</button>
              </div>
              <div id="file-formulir" class="" <?php if (!isset($error['file_upload_3'])) {
                echo "hidden";
              } ?>>
                <input class="form-control <?php if (isset($error['file_upload_3'])) {
                  echo $invalid;
                } ?>" type="file" name="file-formulir" value="<?php echo $data['link_formulir']; ?>">
                <div id="input_file_formulir_feedback" class="valid-feedback">
                  Good
                </div>
                <div id="input_file_formulir_feedback" class="invalid-feedback">
                  <?php echo $upload_invalid; ?>
                </div>
              </div>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <button class="btn btn-outline-primary me-md-2" type="button" id="btn_cancel_delete">Cancel</button>
              <input type="submit" name="submit" value="Submit" class="btn btn-primary text-white">
            </div>
          </form>
        </div>
      </div>


      <script type="text/javascript" src="<?php echo url_for('/js/anggota_masuk.js'); ?>"></script>
<?php include(SHARED_PATH . '/app_footer.php'); ?>
