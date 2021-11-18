<?php
  require_once('../../private/initialize.php');

  $id = $_GET['id'];
  $target_dir = PUBLIC_PATH. '/uploads/pembukuan_keluar/pembayaran_anggota_keluar/';
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
  is_admin("pembukuan_keluar/pembayaran_anggota_keluar");

  if (is_post_request() && $id !== "") {
    $data = pembayaran_anggota_keluar_find_one($_GET['id']);

    $result = pembayaran_anggota_keluar_update($id);

    $file_name = [$data['no_anggota']."-pembayaran-anggota-keluar",
      $data['no_anggota']."-bukti-bayar"];

    $field_name = ["pembayaran_anggota_keluar", "bukti_bayar"];

    $file_upload = [$_FILES["file-pembayaran-anggota-keluar"],
      $_FILES["file-bukti-bayar"]];

    $target_dir .= $data['no_anggota']."/".$data['folder']."/";

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
              $file = substr($file_name[$i],strlen($data['no_anggota']) + 1);
              $sql = "UPDATE pembayaran_anggota_keluar SET link_".$field_name[$i]." = '".$file_name[$i].".".$image_file_type[$i]."' ";
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
    $data = pembayaran_anggota_keluar_find_one($_GET['id']);
    if (isset($data)) {
      $file_dir = "/uploads/pembukuan_keluar/pembayaran_anggota_keluar/".$data['no_anggota']."/".$data['folder']."/";
      $page_title = "Edit Data";
      $breadcumb_name = ['Pembukuan Keluar','Pembayaran Anggota Keluar','Edit'];
      $breadcumb_link = ['pembukuan_keluar','pembukuan_keluar/pembayaran_anggota_keluar/',
      '/pembukuan_keluar/pembayaran_anggota_keluar/edit.php'];
    } else {
      redirect_to(url_for('/pembukuan_keluar/pembayaran_anggota_keluar/'));
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
          <form enctype="multipart/form-data" method="post" action="<?php echo url_for('/pembukuan_keluar/pembayaran_anggota_keluar/edit.php?id='.$id); ?>">
            <div class="mb-3">
              <label class="form-label">Tanggal</label>
              <input class="form-control" type="text" placeholder="" aria-label="" name="no-urut" value="<?php echo substr($data['insert_date'],0, 10); ?>" disabled readonly>
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
              <label class="form-label">No Urut Anggota</label>
              <input class="form-control" type="text" placeholder="Input Nomor" aria-label="" name="no-urut" value="<?php echo $data['no_anggota']; ?>" disabled required>
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
              <label class="form-label">Jumlah</label>
              <input id="input_jumlah" class="form-control <?php echo $valid ?>" type="number" placeholder="Input Jumlah" aria-label="" name="jumlah" value="<?php echo $data['jumlah']; ?>" required disabled>
              <div id="input_jumlah_feedback" class="valid-feedback">
                Good
              </div>
              <div id="input_jumlah_feedback" class="invalid-feedback">
                Please Fill This
              </div>
            </div>
            <div class="mb-3">
              <div class="row">
                <div class="col-8">
                  <label  class="form-label">Pembayaran Anggota Keluar</label>
                </div>
                <div class="col-4">
                  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button id="btn-edit-pembayaran-anggota-keluar" class="btn btn-outline-primary btn-edit-file" type="button" onclick="EditFile('btn-edit-pembayaran-anggota-keluar','btn-file-pembayaran-anggota-keluar','file-pembayaran-anggota-keluar')">Edit</button>
                  </div>
                </div>
              </div>
              <div class="d-grid gap-2">
                <button id="btn-file-pembayaran-anggota-keluar" class="btn btn-outline-primary" type="button" onclick="location.href = '<?php echo url_for($file_dir.$data['link_pembayaran_anggota_keluar']); ?>';" <?php if (isset($error['file_upload_0'])) {
                  echo "hidden";
                } ?>>FILE PEMBAYARAN ANGGOTA KELUAR</button>
              </div>
              <div id="file-pembayaran-anggota-keluar" class="" <?php if (!isset($error['file_upload_0'])) {
                echo "hidden";
              } ?>>
                <input class="form-control <?php if (isset($error['file_upload_0'])) {
                  echo $invalid;
                } ?>" type="file" name="file-pembayaran-anggota-keluar" value="<?php echo $data['link_pembayaran_anggota_keluar']; ?>">
                <div id="input_file_pembayaran_anggota_keluar_feedback" class="valid-feedback">
                  Good
                </div>
                <div id="input_file_pembayaran_anggota_keluar_feedback" class="invalid-feedback">
                  <?php echo $upload_invalid; ?>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <div class="row">
                <div class="col-8">
                  <label  class="form-label">Bukti Bayar</label>
                </div>
                <div class="col-4">
                  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button id="btn-edit-bukti-bayar" class="btn btn-outline-primary btn-edit-file" type="button" onclick="EditFile('btn-edit-bukti-bayar','btn-file-bukti-bayar','file-bukti-bayar')">Edit</button>
                  </div>
                </div>
              </div>
              <div class="d-grid gap-2">
                <button id="btn-file-bukti-bayar" class="btn btn-outline-primary" type="button" onclick="location.href = '<?php echo url_for($file_dir.$data['link_bukti_bayar']); ?>';" <?php if (isset($error['file_upload_1'])) {
                  echo "hidden";
                } ?>>FILE BUKTI BAYAR</button>
              </div>
              <div id="file-bukti-bayar" class="" <?php if (!isset($error['file_upload_1'])) {
                echo "hidden";
              } ?>>
                <input class="form-control <?php if (isset($error['file_upload_1'])) {
                  echo $invalid;
                } ?>" type="file" name="file-bukti-bayar" value="<?php echo $data['link_bukti_bayar']; ?>">
                <div id="input_file_bukti_bayar_feedback" class="valid-feedback">
                  Good
                </div>
                <div id="input_file_bukti_bayar_feedback" class="invalid-feedback">
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


      <script type="text/javascript" src="<?php echo url_for('/js/pembayaran_anggota_keluar.js'); ?>"></script>
<?php include(SHARED_PATH . '/app_footer.php'); ?>
