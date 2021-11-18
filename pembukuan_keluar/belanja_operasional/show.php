<?php
  require_once('../../private/initialize.php');

  $no_urut = $_GET['id'];
  $page_title = "PRINT";

  if ($no_urut !== "") {
    $data = belanja_operasional_find_one($no_urut);
    if (!isset($data)) {
      redirect_to(url_for('/pembukuan_keluar/belanja_operasional/'));
    }
  }

  include(SHARED_PATH. '/app_header.php');
?>
            <div class="card card-wrapping" id="printArea">
              <h2 class="bg-primary print-header text-white" style="text-align: center;">BELANJA OPERASIONAL</h2>
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
                  <td> <h5>KODE TRANSAKSI</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <h5><?php echo $data['kode_transaksi'] ?></h5> </td>
                </tr>
                <tr>
                  <td> <h5>URIAN BELANJA</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <h5><?php echo $data['uraian_belanja'] ?></h5> </td>
                </tr>
                <tr>
                  <td> <h5>JUMLAH</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <h5><?php echo "RP. " . number_format($data['jumlah'], '0','', '.'); ?></h5> </td>
                </tr>
                <tr>
                  <td> <h5>FOTO KWITANSI</h5> </td>
                  <td> <h5>:</h5> </td>
                  <td> <img src="<?php echo url_for('/uploads/pembukuan_keluar/belanja_operasional/'.$data['id'].'/'.$data['link_kwitansi']); ?>" alt="" style="height: 210px;"> </td>
                </tr>
              </table>
            </div>
            <button type="button" name="button" class="btn btn-primary text-white btn-print" id="btn_print" >PRINT</button>


<?php
  include(SHARED_PATH. '/app_footer.php');
 ?>
