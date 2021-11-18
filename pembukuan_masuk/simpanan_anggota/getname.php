<?php
  require_once('../../private/initialize.php');

  $sql = "SELECT nama_anggota FROM anggota_masuk ";
  $sql.= "WHERE no_anggota = ?";

  $stmt = $db->prepare($sql);
  $stmt->bind_param("s", $_GET['q']);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($nama_anggota);
  $stmt->fetch();
  $stmt->close();

  $data = mysqli_fetch_assoc(rekap_anggota_find_one($_GET['q']));

  if (isset($data['status'])) {
    if ($data['status'] == 'tidak aktif') {
      echo "(Anggota Sudah Tidak Aktif) ".$nama_anggota;
    } else {
      echo $nama_anggota;
    }
  }
 ?>
