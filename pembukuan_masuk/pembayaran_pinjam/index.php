<?php
  require_once('../../private/initialize.php');

  $page_title = "Pembayaran Pinjam";
  $breadcumb_name = ['Pembukuan Masuk','Pembayaran Pinjam'];
  $breadcumb_link = ['pembukuan_masuk','/pembukuan_masuk/pembayaran_pinjam/'];
  $limit = 100;
  $anggota = pembayaran_pinjam_find_all_index($limit);
  $cari_data = '';
  $hidden_th = '';
  $hidden_empty = 'hidden';
  $check_database = pembayaran_pinjam_find_all_index(1);

  if (mysqli_fetch_assoc($check_database) == null) {
    $hidden_th = "hidden";
    $hidden_empty = '';
  }

  if (is_post_request()) {
    redirect_to(url_for('/pembukuan_masuk/pembayaran_pinjam/show.php?id='.$_POST['cari-data']));
  }

  include(SHARED_PATH . '/app_header.php');
  $hidden_button = "";
  if ($user_status != "admin") {
    $hidden_button = "hidden";
  }
 ?>
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <?php generate_breadcumb($breadcumb_name, $breadcumb_link);  ?>
    </nav>
   <h1 id="page-title" class="border border-5 border-primary custom-round">PEMBAYARAN PINJAM</h1>
   <div class="card card-wrapping">
     <div class="row">
       <div class="col"></div>
       <div class="col-4 col-sm-4">
         <div class="card card-menu" <?php echo $hidden_button; ?>>
           <button type="button" class="btn btn-outline-primary btn-menu" onclick="location.href = '<?php echo url_for('/pembukuan_masuk/pembayaran_pinjam/input.php'); ?>';">
             <img src="<?php echo url_for('/assets/images/contract-1.svg'); ?>" class="image-fluid menu-icon" alt="...">
             <h4 id="menu-title">INPUT</h4>
           </button>
         </div>
       </div>
       <div class="col"></div>
     </div>
     <div class="table-database" id="table-databse">
       <h2>List Data Terakhir <?php echo $page_title; ?></h2>
       <form class="d-flex" action="<?php echo url_for('/pembukuan_masuk/pembayaran_pinjam/index.php'); ?>" method="post">
        <input class="form-control me-2" type="search" placeholder="Cari Berdasarkan No Anggota" aria-label="Search" name="cari-data" value="<?php echo $cari_data; ?>">
        <button class="btn btn-outline-success" type="submit">Search</button>
       </form>
       <div class="d-grid gap-2 d-md-flex justify-content-md-end" style="margin-top: 10px">
         <button type="button" class="btn btn-primary btn-sm text-white active" id="btn_25">25</button>
         <button type="button" class="btn btn-primary btn-sm text-white" id="btn_50">50</button>
         <button type="button" class="btn btn-primary btn-sm text-white" id="btn_75">75</button>
         <button type="button" class="btn btn-primary btn-sm text-white" id="btn_100">100</button>
       </div>
       <h3 <?php echo $hidden_empty; ?>>Belum Ada Data</h3>
       <table class="table table-striped table-bordered table-data table-hover">
         <tr class="bg-primary" <?php echo $hidden_th; ?>>
           <th>No</th>
           <th>No Anggota</th>
           <th>Nama Anggota</th>
           <th>Pembayaran Bulan</th>
           <th>Pokok Pinjaman</th>
           <th>Bagi Hasil</th>
           <th>Ujrah</th>
           <th <?php echo $hidden_button; ?>>Action</th>
         </tr>
         <?php $i = 1;
         while($data = mysqli_fetch_assoc($anggota)){?>
           <tr id="<?php echo 'list_no_'.$i; ?>" class="">
             <td><?php echo $i; ?></td>
             <td><?php echo $data['no_anggota']; ?></td>
             <td><?php echo $data['nama_anggota']; ?></td>
             <td><?php echo substr($data['pembayaran_bulan'], 5, 2); ?></td>
             <td><?php echo "Rp. ".number_format($data['pokok_pinjaman'], '0', '', '.'); ?></td>
             <td><?php echo "Rp. ".number_format($data['bagi_hasil'], '0', '', '.'); ?></td>
             <td><?php echo "Rp. ".number_format($data['ujrah'], '0', '', '.'); ?></td>
             <td <?php echo $hidden_button; ?>> <a href="<?php echo url_for('/pembukuan_masuk/pembayaran_pinjam/edit.php?id='.$data['id']); ?>">Edit/View</a> | <a href="<?php echo url_for('/pembukuan_masuk/pembayaran_pinjam/delete.php?id='.$data['id']); ?>">Delete</a> </td>
           </tr>
         <?php $i++; } ?>
       </table>
     </div>
   </div>

   <script type="text/javascript" src="<?php echo url_for('/js/pembayaran_pinjam.js'); ?>">

   </script>
<?php include(SHARED_PATH . '/app_footer.php'); ?>
