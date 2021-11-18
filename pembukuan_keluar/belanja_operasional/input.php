<?php
  require_once('../../private/initialize.php');

  $target_dir = PUBLIC_PATH. '/uploads/pembukuan_keluar/belanja_operasional/';
  $page_title = "Input Belanja Operasional";
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
  $data = belanja_operasional_count_data();

  $anggota['uraian-belanja'] = '';
  $anggota['kode-transaksi'] = '';
  $anggota['jumlah'] = '';

  $page_title_data = "Belanja Operasional";
  $breadcumb_name = ['Pembukuan Keluar','Belanja Operasional','Input'];
  $breadcumb_link = ['pembukuan_keluar','/pembukuan_keluar/belanja_operasional/',
  '/pembukuan_keluar/belanja_operasional/input.php'];
  include(SHARED_PATH . '/app_header.php');
  is_admin("pembukuan_keluar/belanja_operasional");

  if (is_post_request()) {
    $valid = "is-valid";
    $invalid = "is-invalid";
    $upload_invalid = "- Maaf, Hanya file JPG, JPEG, PNG & GIF yang bisa diupload <br> - Ukuran File maksimal 5MB";
    $upload_kembali = "Mohon diupload Kembali";

    $anggota['uraian-belanja'] = $_POST['uraian-belanja'];
    $anggota['kode-transaksi'] = $_POST['kode-transaksi'];
    $anggota['jumlah'] = $_POST['jumlah'];

    $id_number = $data['count'] + 1;
    //FILE NAMING
    $file_name = [$id_number."-kwitansi"];
    //FILE ASSIGN
    $file_upload = [$_FILES["file-kwitansi"]];

    if (!file_exists($target_dir.$id_number."/")) {
      mkdir($target_dir.$id_number."/");
    }

    $target_dir .= $id_number."/";

    for ($i=0; $i < sizeof($file_upload); $i++) {
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
        $anggota['file-kwitansi'] = $file_link[0];

        belanja_operasional_insert_data($anggota);
        $success = true;
      }

      if ($success) {
        redirect_to(url_for('/pembukuan_keluar/belanja_operasional/create.php'));
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
          <form enctype="multipart/form-data" method="post" action="<?php echo url_for('/pembukuan_keluar/belanja_operasional/input.php'); ?>">
            <div class="mb-3">
              <label class="form-label">Bulan</label>
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
              <label class="form-label">Uraian Belanja</label>
              <textarea class="form-control form-control <?php if (isset($error['error_input_uraian'])) {
                echo $invalid;
              } else {
                echo $valid;
              } ?>" name="uraian-belanja" placeholder="Input Uraian" id="input_uraian_belanja" style="height: 100px" required><?php echo $anggota['uraian-belanja']; ?></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Jumlah</label>
              <input class="form-control <?php echo $valid; ?>" type="number" placeholder="Input Jumlah" aria-label="" name="jumlah" id="input_jumlah" value="<?php echo $anggota['jumlah']; ?>" required>
              <div id="input_jumlah_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_jumlah_feedback" class="invalid-feedback">
                Please fill this
              </div>
            </div>
            <div class="mb-3">
              <label  class="form-label">Upload Kwitansi</label>
              <input class="form-control <?php echo $invalid; ?>" type="file" name="file-kwitansi" id="input_file_kwitansi" required>
              <div id="input_kwitansi_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_kwitansi_feedback" class="invalid-feedback">
                <?php if (isset($error['file_upload_0'])) {
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

      <script type="text/javascript" src="<?php echo url_for('/js/belanja_operasional.js'); ?>"></script>

<?php include(SHARED_PATH . '/app_footer.php'); ?>
