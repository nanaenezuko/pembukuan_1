<?php
  require_once('../../private/initialize.php');

  $id = $_GET['id'];
  $target_dir = PUBLIC_PATH. '/uploads/keanggotaan/anggota_keluar/';
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
  is_admin("keanggotaan/anggota_keluar");

  if (is_post_request() && $id !== "") {
    $data = anggota_keluar_find_one($_GET['id']);

    $result = anggota_keluar_update($id);

    $file_name = [$data['no_anggota']."-form",
      $data['no_anggota']."-bukti-kirim"];

    $field_name = ["form_keluar", "bukti_kirim"];

    $file_upload = [$_FILES["file-form"],
      $_FILES["file-bukti-kirim"]];

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
              $sql = "UPDATE anggota_keluar SET link_".$field_name[$i]." = '".$file_name[$i].".".$image_file_type[$i]."' ";
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
    $data = anggota_keluar_find_one($_GET['id']);
    if (isset($data)) {
      $file_dir = "/uploads/keanggotaan/anggota_keluar/".$data['no_anggota']."/";
      $page_title = "Edit Data";
      $breadcumb_name = ['Keanggotaan','Anggota Keluar','Edit'];
      $breadcumb_link = ['keanggotaan','keanggotaan/anggota_keluar/',
      '/keanggotaan/anggota_keluar/edit.php'];
    } else {
      redirect_to(url_for('/keanggotaan/anggota_keluar/'));
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
          <form enctype="multipart/form-data" method="post" action="<?php echo url_for('/keanggotaan/anggota_keluar/edit.php?id='.$id); ?>">
            <div class="mb-3">
              <label class="form-label">No Urut Anggota</label>
              <input class="form-control" type="text" placeholder="Input Nomor" aria-label="" name="no-urut" value="<?php echo $data['no_anggota']; ?>" disabled readonly>
            </div>
            <div class="mb-3">
              <label class="form-label">Nama Anggota</label>
              <input id="input_nama_anggota" class="form-control <?php echo $valid; ?>" type="text" placeholder="Input Nama" aria-label="" name="nama" value="<?php echo $data['nama_anggota']; ?>" disabled readonly>
              <div id="input_nama_anggota_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_nama_anggota_feedback" class="invalid-feedback">
                Please Fill This
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Jumlah Simpanan</label>
              <input id="input_jumlah_simpanan" class="form-control <?php echo $valid ?>" type="number" placeholder="Input Jumlah Simpanan" aria-label="" name="jumlah_simpanan" value="<?php echo $data['jumlah_simpanan']; ?>" required>
              <div id="input_nik_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_nik_feedback" class="invalid-feedback">
                Please Fill This
              </div>
            </div>
            <div class="mb-3">
              <div class="row">
                <div class="col-8">
                  <label  class="form-label">Form</label>
                </div>
                <div class="col-4">
                  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button id="btn-edit-form" class="btn btn-outline-primary btn-edit-file" type="button" onclick="EditFile('btn-edit-form','btn-file-form','file-form')">Edit</button>
                  </div>
                </div>
              </div>
              <div class="d-grid gap-2">
                <button id="btn-file-form" class="btn btn-outline-primary" type="button" onclick="location.href = '<?php echo url_for($file_dir.$data['link_form_keluar']); ?>';" <?php if (isset($error['file_upload_0'])) {
                  echo "hidden";
                } ?>>FILE FORM</button>
              </div>
              <div id="file-form" class="" <?php if (!isset($error['file_upload_0'])) {
                echo "hidden";
              } ?>>
                <input class="form-control <?php if (isset($error['file_upload_0'])) {
                  echo $invalid;
                } ?>" type="file" name="file-form" value="<?php echo $data['link_form_keluar']; ?>">
                <div id="input_file_form_feedback" class="valid-feedback">
                  Good
                </div>
                <div id="input_file_form_feedback" class="invalid-feedback">
                  <?php echo $upload_invalid; ?>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <div class="row">
                <div class="col-8">
                  <label  class="form-label">Bukti Kirim</label>
                </div>
                <div class="col-4">
                  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button id="btn-edit-bukti-kirim" class="btn btn-outline-primary btn-edit-file" type="button" onclick="EditFile('btn-edit-bukti-kirim','btn-file-bukti-kirim','file-bukti-kirim')">Edit</button>
                  </div>
                </div>
              </div>
              <div class="d-grid gap-2">
                <button id="btn-file-bukti-kirim" class="btn btn-outline-primary" type="button" onclick="location.href = '<?php echo url_for($file_dir.$data['link_bukti_kirim']); ?>';" <?php if (isset($error['file_upload_1'])) {
                  echo "hidden";
                } ?>>FILE BUKTI KIRIM</button>
              </div>
              <div id="file-bukti-kirim" class="" <?php if (!isset($error['file_upload_1'])) {
                echo "hidden";
              } ?>>
                <input class="form-control <?php if (isset($error['file_upload_1'])) {
                  echo $invalid;
                } ?>" type="file" name="file-bukti-kirim" value="<?php echo $data['link_bukti_kirim']; ?>">
                <div id="input_file_bukti_kirim_feedback" class="valid-feedback">
                  Good
                </div>
                <div id="input_file_bukti_kirim_feedback" class="invalid-feedback">
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


      <script type="text/javascript" src="<?php echo url_for('/js/anggota_keluar.js'); ?>"></script>
<?php include(SHARED_PATH . '/app_footer.php'); ?>
