<?php
  require_once('../../private/initialize.php');

  $page_title = "Rekap Anggota";
  $breadcumb_name = ['Keanggotaan','Rekap Anggota'];
  $breadcumb_link = ['keanggotaan','/keanggotaan/rekap_anggota/'];
  $limit = 100;
  $anggota = rekap_anggota_find_all($limit);
  $cari_data = '';
  $hidden_th = '';
  $hidden_empty = 'hidden';
  $check_database = rekap_anggota_find_all(1);

  if (mysqli_fetch_assoc($check_database) == null) {
    $hidden_th = "hidden";
    $hidden_empty = '';
  }

  if (is_post_request()) {
    $anggota = rekap_anggota_search_data($_POST['cari-data'], $limit);
    $cari_data = $_POST['cari-data'];
  }

  include(SHARED_PATH . '/app_header.php');
 ?>
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <?php generate_breadcumb($breadcumb_name, $breadcumb_link);  ?>
    </nav>
   <h1 id="page-title" class="border border-5 border-primary custom-round">REKAP ANGGOTA</h1>
   <div class="card card-wrapping">
     <div class="table-database" id="table-databse">
       <h2>List Data <?php echo $page_title; ?></h2>
       <form class="d-flex" action="<?php echo url_for('/keanggotaan/rekap_anggota/index.php'); ?>" method="post">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="cari-data" value="<?php echo $cari_data; ?>">
        <button class="btn btn-outline-success" type="submit">Search</button>
       </form>
       <div class="d-grid gap-2 d-md-flex justify-content-md-end" style="margin-top: 10px">
         <button type="button" class="btn btn-primary btn-sm text-white active" id="btn_25">25</button>
         <button type="button" class="btn btn-primary btn-sm text-white" id="btn_50">50</button>
         <button type="button" class="btn btn-primary btn-sm text-white" id="btn_75">75</button>
         <button type="button" class="btn btn-primary btn-sm text-white" id="btn_100">100</button>
       </div>
       <h3 <?php echo $hidden_empty; ?>>Belum Ada Data</h3>
       <table class="table table-striped table-bordered table-data">
         <tr class="bg-primary" <?php echo $hidden_th; ?>>
           <th>No</th>
           <th>No Anggota</th>
           <th>Nama Anggota</th>
           <th>NIK</th>
           <th>Unit</th>
           <th>Tanggal Masuk</th>
           <th>Tanggal Keluar</th>
           <th>Status</th>
         </tr>
         <?php $i = 1;
         while($data = mysqli_fetch_assoc($anggota)){?>
           <tr id="<?php echo 'list_no_'.$i; ?>">
             <td><?php echo $i; ?></td>
             <td><?php echo $data['no_anggota']; ?></td>
             <td><?php echo $data['nama_anggota']; ?></td>
             <td><?php echo $data['nik']; ?></td>
             <td><?php echo $data['unit']; ?></td>
             <td><?php echo substr($data['Tanggal Masuk'], 0, 10); ?></td>
             <td><?php echo (substr($data['Tanggal Keluar'], 0, 10) == null) ? '-' : substr($data['Tanggal Keluar'], 0, 10); ?></td>
             <td><?php echo $data['status']; ?></td>
           </tr>
         <?php $i++; } ?>
       </table>
     </div>
   </div>

   <script type="text/javascript" src="<?php echo url_for('/js/rekap_anggota.js'); ?>">
   </script>
<?php include(SHARED_PATH . '/app_footer.php'); ?>
