<?php
  require_once('../../private/initialize.php');

  $page_title = "Lihat Data";
  $breadcumb_name = ['Pembukuan Masuk','Simpanan Anggota','Lihat Data'];
  $breadcumb_link = ['','/pembukuan_masuk/simpanan_anggota/',''];
  $cari_data = '';
  $hidden_th = '';

  if (is_post_request()) {
    redirect_to(url_for('/pembukuan_masuk/simpanan_anggota/show.php?id='.$_POST['cari-data']));
  }

  if ($_GET['id'] == "") {
    redirect_to(url_for('/pembukuan_masuk/simpanan_anggota'));
  } else {
    $anggota = simpanan_anggota_search_data($_GET['id']);
    $cari_data = $_GET['id'];
  }

  $data_fetch = mysqli_fetch_assoc(simpanan_anggota_count_data_by_id($_GET['id']));
  if ($data_fetch['count'] == 0) {
    $hidden_th = "hidden";
  }

  include(SHARED_PATH . '/app_header.php');
 ?>
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <?php generate_breadcumb($breadcumb_name, $breadcumb_link);  ?>
    </nav>
   <h1 id="page-title" class="border border-5 border-primary custom-round">SIMPANAN ANGGOTA DATA</h1>
   <div class="card card-wrapping">
     <div class="row">
       <div class="col"></div>
       <div class="col-4 col-sm-4">
       </div>
       <div class="col"></div>
     </div>
     <div class="table-database" id="table-databse">
       <h2>List Data <?php echo $_GET['id']; ?></h2>
       <form class="d-flex" action="<?php echo url_for('/pembukuan_masuk/simpanan_anggota/show.php'); ?>" method="post">
        <input class="form-control me-2" type="search" placeholder="Cari Berdasarkan No Anggota" aria-label="Search" name="cari-data" value="<?php echo $cari_data; ?>">
        <button class="btn btn-outline-success" type="submit">Search</button>
       </form>
       <table class="table table-striped table-bordered table-data table-hover" <?php echo $hidden_th; ?>>
         <tr class="bg-primary">
           <th>No</th>
           <th>No Anggota</th>
           <th>Nama Anggota</th>
           <th>Simpanan Pokok</th>
           <th>Simpanan Wajib</th>
           <th>Simpanan Sukarela</th>
           <th>Action</th>
         </tr>
         <?php $i = 1;
         while($data = mysqli_fetch_assoc($anggota)){?>
             <tr id="<?php echo 'list_no_'.$i; ?>" >
               <td><?php echo $i; ?></td>
               <td><?php echo $data['no_anggota']; ?></td>
               <td><?php echo $data['nama_anggota']; ?></td>
               <td><?php echo "Rp. ".number_format($data['simpanan_pokok'], '0', '', '.');; ?></td>
               <td><?php echo "Rp. ".number_format($data['simpanan_wajib'], '0', '', '.');; ?></td>
               <td><?php echo "Rp. ".number_format($data['simpanan_sukarela'], '0', '', '.');; ?></td>
               <td> <a href="<?php echo url_for('/pembukuan_masuk/simpanan_anggota/edit.php?id='.$data['id']); ?>">Edit/View</a> | <a href="<?php echo url_for('/pembukuan_masuk/simpanan_anggota/delete.php?id='.$data['id']); ?>">Delete</a> </td>
             </tr>
         <?php $i++; }
         if ($data_fetch['count'] == 0) {
           echo "<h4 style='text-align: center; color: red; margin: 10px 0;'>Data Tidak Ditemukan</h4>";
         }?>
       </table>
     </div>
   </div>

   <script type="text/javascript" src="<?php echo url_for('/js/simpanan_anggota.js'); ?>">

   </script>
<?php include(SHARED_PATH . '/app_footer.php'); ?>
