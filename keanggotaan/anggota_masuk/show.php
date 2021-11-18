<?php
  require_once('../../private/initialize.php');

  $no_urut = $_GET['id'];
  $page_title = "PRINT";

  if ($no_urut !== "") {
    $data = anggota_masuk_find_one($no_urut);
    if (!isset($data)) {
      redirect_to(url_for('/keanggotaan/anggota_masuk/'));
    }
  }

  include(SHARED_PATH. '/app_header.php');
?>
            <div class="card card-wrapping" id="printArea">
              <h2 class="bg-primary print-header text-white" style="text-align: center;">ANGGOTA MASUK</h2>
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
                  <td> <h5>NIK</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <h5><?php echo $data['nik'] ?></h5> </td>
                </tr>
                <tr>
                  <td> <h5>NO NPWP</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <h5><?php echo $data['no_npwp'] ?></h5> </td>
                </tr>
                <tr>
                  <td> <h5>TANGGAL LAHIR</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <h5><?php echo $data['tanggal_lahir'] ?></h5> </td>
                </tr>
                <tr>
                  <td> <h5>NAMA</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <h5><?php echo $data['agama'] ?></h5> </td>
                </tr>
                <tr>
                  <td> <h5>JENIS KELAMIN</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <h5><?php echo $data['jenis_kelamin'] == 'l' ? 'Laki - Laki' : 'Perempuan'; ?></h5> </td>
                </tr>
                <tr>
                  <td> <h5>UNIT</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <h5><?php echo $data['unit'] ?></h5> </td>
                </tr>
                <tr>
                  <td> <h5>ALAMAT</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <h5><?php echo $data['alamat'] ?></h5> </td>
                </tr>
                <tr>
                  <td> <h5>FOTO KTP</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <img src="<?php echo url_for('/uploads/keanggotaan/anggota_masuk/'.$data['no_anggota'].'/'.$data['link_ktp']); ?>" alt="" style="height: 210px;"> </td>
                </tr>
                <tr>
                  <td> <h5>FOTO NPWP</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <img src="<?php echo url_for('/uploads/keanggotaan/anggota_masuk/'.$data['no_anggota'].'/'.$data['link_npwp']); ?>" alt="" style="height: 210px;"> </td>
                </tr>
                <tr>
                  <td> <h5>FOTO DIRI</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <img src="<?php echo url_for('/uploads/keanggotaan/anggota_masuk/'.$data['no_anggota'].'/'.$data['link_foto']); ?>" alt="" style="height: 210px;"> </td>
                </tr>
                <tr>
                  <td> <h5>FOTO FORMULIR</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <img src="<?php echo url_for('/uploads/keanggotaan/anggota_masuk/'.$data['no_anggota'].'/'.$data['link_formulir']); ?>" alt="" style="height: 210px;"> </td>
                </tr>
              </table>
            </div>
            <button type="button" name="button" class="btn btn-primary text-white btn-print" id="btn_print" >PRINT</button>


<?php
  include(SHARED_PATH. '/app_footer.php');
 ?>
