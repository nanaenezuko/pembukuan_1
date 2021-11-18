<?php
  require_once('../../private/initialize.php');

  $no_urut = $_GET['id'];
  $page_title = "PRINT";

  if ($no_urut !== "") {
    $data = pembayaran_pajak_find_one($no_urut);
    if (!isset($data)) {
      redirect_to(url_for('/pembukuan_keluar/pembayaran_pajak/'));
    }
  }

  include(SHARED_PATH. '/app_header.php');
?>
            <div class="card card-wrapping" id="printArea">
              <h2 class="bg-primary print-header text-white" style="text-align: center;">PEMBAYARAN PAJAK</h2>
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
                  <td> <h5>BULAN</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <h5><?php echo substr($data['insert_date'], 5, 2); ?></h5> </td>
                </tr>
                <tr>
                  <td> <h5>JENIS PAJAK</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <h5><?php echo $data['jenis_pajak'] ?></h5> </td>
                </tr>
                <tr>
                  <td> <h5>KODE TRANSAKSI</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <h5><?php echo $data['kode_transaksi'] ?></h5> </td>
                </tr>
                <tr>
                  <td> <h5>JUMLAH</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <h5><?php echo "RP. " . number_format($data['jumlah'], '0','', '.'); ?></h5> </td>
                </tr>
                <tr>
                  <td> <h5>FOTO BILL PAJAK</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <img src="<?php echo url_for('/uploads/pembukuan_keluar/pembayaran_pajak/'.$data['id'].'/'.$data['link_bill_pajak']); ?>" alt="" style="height: 210px;"> </td>
                </tr>
                <tr>
                  <td> <h5>FOTO BUKTI BAYAR</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <img src="<?php echo url_for('/uploads/pembukuan_keluar/pembayaran_pajak/'.$data['id'].'/'.$data['link_bukti_bayar']); ?>" alt="" style="height: 210px;"> </td>
                </tr>
              </table>
            </div>
            <button type="button" name="button" class="btn btn-primary text-white btn-print" id="btn_print" >PRINT</button>


<?php
  include(SHARED_PATH. '/app_footer.php');
 ?>
