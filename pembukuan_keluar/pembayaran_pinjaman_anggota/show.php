<?php
  require_once('../../private/initialize.php');

  $no_urut = $_GET['id'];
  $page_title = "PRINT";

  if ($no_urut !== "") {
    $data = pembayaran_pinjaman_anggota_find_one($no_urut);
    if (!isset($data)) {
      redirect_to(url_for('/pembukuan_keluar/pembayaran_pinjaman_anggota/'));
    }
  }

  include(SHARED_PATH. '/app_header.php');
?>
            <div class="card card-wrapping" id="printArea">
              <h2 class="bg-primary print-header text-white" style="text-align: center;">PEMBAYARAN PINJAMAN ANGGOTA</h2>
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
                  <td> <h5>TANGGAL</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <h5><?php echo substr($data['insert_date'], 0, 10); ?></h5> </td>
                </tr>
                <tr>
                  <td> <h5>KODE TRANSAKSI</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <h5><?php echo $data['kode_transaksi'] ?></h5> </td>
                </tr>
                <tr>
                  <td> <h5>NO URUT ANGGOTA</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <h5><?php echo $data['no_anggota'] ?></h5> </td>
                </tr>
                <tr>
                  <td> <h5>NAMA ANGGOTA</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <h5><?php echo $data['nama_anggota'] ?></h5> </td>
                </tr>
                <tr>
                  <td> <h5>LAMA PINJAMAN</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <h5><?php echo $data['lama_pinjaman'] ?></h5> </td>
                </tr>
                <tr>
                  <td> <h5>JUMLAH PINJAMAN</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <h5><?php echo "RP. " . number_format($data['jumlah_pinjaman'], '0','', '.'); ?></h5> </td>
                </tr>
                <tr>
                  <td> <h5>FOTO FORMULIR</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <img src="<?php echo url_for('/uploads/pembukuan_keluar/pembayaran_pinjaman_anggota/'.$data['no_anggota'].'/'.$data['folder'].'/'.$data['link_formulir']); ?>" alt="" style="height: 210px;"> </td>
                </tr>
                <tr>
                  <td> <h5>FOTO BUKTI BAYAR</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <img src="<?php echo url_for('/uploads/pembukuan_keluar/pembayaran_pinjaman_anggota/'.$data['no_anggota'].'/'.$data['folder'].'/'.$data['link_bukti_bayar']); ?>" alt="" style="height: 210px;"> </td>
                </tr>
              </table>
            </div>
            <button type="button" name="button" class="btn btn-primary text-white btn-print" id="btn_print" >PRINT</button>


<?php
  include(SHARED_PATH. '/app_footer.php');
 ?>
