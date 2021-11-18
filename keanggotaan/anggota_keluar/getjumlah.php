<?php
  require_once('../../private/initialize.php');

  $sql = "SELECT (SUM(simpanan_pokok)+SUM(simpanan_wajib)+SUM(simpanan_sukarela)) AS total ";
  $sql.= "FROM simpanan_anggota WHERE no_anggota = ?";

  $stmt = $db->prepare($sql);
  $stmt->bind_param("s", $_GET['q']);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($total);
  $stmt->fetch();
  $stmt->close();

  if ($total != "") {
    echo $total;
  } else {
    echo "0";
  }
 ?>
