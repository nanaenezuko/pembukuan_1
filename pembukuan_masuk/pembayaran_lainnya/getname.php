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

  echo $nama_anggota;
 ?>
