<?php
  require_once('../../private/initialize.php');

  $id = $_GET['id'];
  $target_dir = PUBLIC_PATH. '/uploads/pembukuan_keluar/belanja_operasional/';
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
  is_admin("pembukuan_keluar/belanja_operasional");

  if (is_post_request() && $id !== "") {
    $data = belanja_operasional_find_one($_GET['id']);

    $result = belanja_operasional_update($id);

    $file_name = [$data['id']."-kwitansi"];

    $field_name = ["kwitansi"];

    $file_upload = [$_FILES["file-kwitansi"]];

    $target_dir .= $data['id']."/";

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
          //redirect_to(url_for('/pembukuan_keluar/anggota_masuk.php'));
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
              $file = substr($file_name[$i],strlen($data['id']) + 1);
              $sql = "UPDATE belanja_operasional SET link_".$field_name[$i]." = '".$file_name[$i].".".$image_file_type[$i]."' ";
              $sql .= "WHERE id = '".$data['id']."' LIMIT 1";
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
    $data = belanja_operasional_find_one($_GET['id']);
    if (isset($data)) {
      $file_dir = "/uploads/pembukuan_keluar/belanja_operasional/".$data['id']."/";
      $page_title = "Edit Data";
      $breadcumb_name = ['Pembukuan Keluar','Belanja Operasional','Edit'];
      $breadcumb_link = ['pembukuan_keluar','pembukuan_keluar/belanja_operasional/',
      '/pembukuan_keluar/belanja_operasional/edit.php'];
    } else {
      redirect_to(url_for('/pembukuan_keluar/belanja_operasional/'));
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
          <form enctype="multipart/form-data" method="post" action="<?php echo url_for('/pembukuan_keluar/belanja_operasional/edit.php?id='.$id); ?>">
            <div class="mb-3">
              <label class="form-label">Bulan</label>
              <input class="form-control" type="text" placeholder="" aria-label="" name="" value="<?php echo substr($data['insert_date'],5, 2); ?>" disabled readonly>
            </div>
            <div class="mb-3">
              <label class="form-label">Uraian Belanja</label>
              <textarea class="form-control form-control <?php if (isset($error['error_input_uraian'])) {
                echo $invalid;
              } else {
                echo $valid;
              } ?>" name="uraian-belanja" placeholder="Input Uraian" id="input_uraian_belanja" style="height: 100px" required><?php echo $data['uraian_belanja']; ?></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Kode Transaksi</label>
              <input class="form-control <?php if (isset($error['error_input_kode_transaksi'])) {
                echo $invalid;
              } else {
                echo $valid;
              } ?>" type="text" placeholder="Input Kode Transaksi" aria-label="" name="kode-transaksi" id="input_kode_transaksi" value="<?php echo $data['kode_transaksi']; ?>" required>
              <div id="input_kode_transaksi_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_kode_transaksi_feedback" class="invalid-feedback">
                please Fill This
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Jumlah</label>
              <input class="form-control <?php echo $valid; ?>" type="number" placeholder="Input Jumlah" aria-label="" name="jumlah" id="input_jumlah" value="<?php echo $data['jumlah']; ?>" required>
              <div id="input_jumlah_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_jumlah_feedback" class="invalid-feedback">
                Please fill this
              </div>
            </div>
            <div class="mb-3">
              <div class="row">
                <div class="col-8">
                  <label  class="form-label">Kwitansi</label>
                </div>
                <div class="col-4">
                  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button id="btn-edit-kwitansi" class="btn btn-outline-primary btn-edit-file" type="button" onclick="EditFile('btn-edit-kwitansi','btn-file-kwitansi','file-kwitansi')">Edit</button>
                  </div>
                </div>
              </div>
              <div class="d-grid gap-2">
                <button id="btn-file-kwitansi" class="btn btn-outline-primary" type="button" onclick="location.href = '<?php echo url_for($file_dir.$data['link_kwitansi']); ?>';" <?php if (isset($error['file_upload_1'])) {
                  echo "hidden";
                } ?>>FILE BUKTI BAYAR</button>
              </div>
              <div id="file-kwitansi" class="" <?php if (!isset($error['file_upload_1'])) {
                echo "hidden";
              } ?>>
                <input class="form-control <?php if (isset($error['file_upload_1'])) {
                  echo $invalid;
                } ?>" type="file" name="file-kwitansi" value="<?php echo $data['link_kwitansi']; ?>">
                <div id="input_file_kwitansi_feedback" class="valid-feedback">
                  Good
                </div>
                <div id="input_file_kwitansi_feedback" class="invalid-feedback">
                  <?php echo $upload_invalid; ?>
                </div>
              </div>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <button class="btn btn-outline-primary me-md-2" type="button" id="btn_cancel_delete">Cancel</button>
              <input type="submit" name="submit" value="Update" class="btn btn-primary text-white">
            </div>
          </form>
        </div>
      </div>


      <script type="text/javascript" src="<?php echo url_for('/js/belanja_operasional.js'); ?>"></script>
<?php include(SHARED_PATH . '/app_footer.php'); ?>
