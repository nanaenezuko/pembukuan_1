<?php
  require_once('../../private/initialize.php');

  $no_urut = $_GET['id'];
  $page_title = "PRINT";

  if ($no_urut !== "") {
    $data = anggota_keluar_find_one($no_urut);
    if (!isset($data)) {
      redirect_to(url_for('/keanggotaan/anggota_keluar/'));
    }
  }

  include(SHARED_PATH. '/app_header.php');
?>
            <div class="card card-wrapping" id="printArea">
              <h2 class="bg-primary print-header text-white" style="text-align: center;">ANGGOTA KELUAR</h2>
              <hr>
              <br>
              <br>
              <table>
                <colgroup>
                   <col span="1" style="width: 40%;">
                   <col span="1" style="width: 3%;">
                   <col span="1" style="width: 57%;">
                </colgroup>
                <tr>
                  <td> <h5>NO ANGGOTA</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <h5><?php echo $data['no_anggota']; ?></h5> </td>
                </tr>
                <tr>
                  <td> <h5>NAMA</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <h5><?php echo $data['nama_anggota'] ?></h5> </td>
                </tr>
                <tr>
                  <td> <h5>JUMLAH SIMPANAN</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <h5><?php echo "RP. " . $data['jumlah_simpanan'] ?></h5> </td>
                </tr>
                <tr>
                  <td> <h5>FOTO FORM</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <img src="<?php echo url_for('/uploads/keanggotaan/anggota_keluar/'.$data['no_anggota'].'/'.$data['link_form_keluar']); ?>" alt="" style="height: 210px;"> </td>
                </tr>
                <tr>
                  <td> <h5>FOTO BUKTI KIRIM</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <img src="<?php echo url_for('/uploads/keanggotaan/anggota_keluar/'.$data['no_anggota'].'/'.$data['link_bukti_kirim']); ?>" alt="" style="height: 210px;"> </td>
                </tr>
              </table>
            </div>
            <button type="button" name="button" class="btn btn-primary text-white btn-print" id="btn_print" >PRINT</button>


<?php
  include(SHARED_PATH. '/app_footer.php');
 ?>
