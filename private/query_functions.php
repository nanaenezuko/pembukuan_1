<?php
  require('validation_functions.php');

  function insert_userdata($data){
    global $db;

    $sql = "INSERT INTO userdata VALUES ";
    $sql .= "(";
    $sql .= "'".db_escape($db, $data['username'])."',";
    $sql .= "'".db_escape($db, $data['password'])."',";
    $sql .= "'".db_escape($db, $data['level'])."'";
    $sql .= ") ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    if ($result) {
      return true;
    } else {
      //INSERT Failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function update_userdata($username,$password){
    global $db;

    $sql = "UPDATE userdata SET password = '".db_escape($db, $password)."' ";
    $sql .= "WHERE username = '".db_escape($db,$username)."' LIMIT 1";
    $result = mysqli_query($db, $sql);

    if ($result) {
      return true;
    } else {
      //INSERT Failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function get_userdata($username){
    global $db;

    $sql = "SELECT * FROM userdata ";
    $sql .= "WHERE username = '". db_escape($db, $username)."' LIMIT 1";
    $result = mysqli_query($db, $sql);
    echo mysqli_error($db);
    db_disconnect($db);
    confirm_result_set($result);
    $data = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $data;
  }

  function generate_no_anggota(){
    global $db;

    $sql = "SELECT no_anggota FROM anggota_masuk ";
    $sql .= "ORDER BY insert_date DESC LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $data = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    $no_anggota = substr($data['no_anggota'], 3, 13);
    if ($no_anggota == "") {
      $no_anggota = "AGT0000000001";
    } else {
      $number = (int) $no_anggota + 1;
      $number_size = strlen($number);
      $no_anggota_size = strlen($no_anggota);
      $no_anggota = "AGT".substr($no_anggota, 0,($no_anggota_size - $number_size)).$number;
    }

    return $no_anggota;
  }

  function anggota_masuk_insert_data($anggota){
    global $db;

    $sql = "INSERT INTO anggota_masuk ";
    $sql .= "VALUES (";
    $sql .= "'". db_escape($db,$anggota['no-urut']) ."',";
    $sql .= "'". db_escape($db,$anggota['nama']) ."',";
    $sql .= "'". db_escape($db,$anggota['nik']) ."',";
    $sql .= "'". db_escape($db,$anggota['no-npwp']) ."',";
    $sql .= "'". db_escape($db,$anggota['tanggal-lahir']) ."',";
    $sql .= "'". db_escape($db,$anggota['agama']) ."',";
    $sql .= "'". db_escape($db,$anggota['jenis-kelamin']) ."',";
    $sql .= "'". db_escape($db,$anggota['unit']) ."',";
    $sql .= "'". db_escape($db,$anggota['alamat']) ."',";
    $sql .= "'". db_escape($db,$anggota['file-ktp']) ."',";
    $sql .= "'". db_escape($db,$anggota['file-npwp']) ."',";
    $sql .= "'". db_escape($db,$anggota['file-foto']) ."',";
    $sql .= "'". db_escape($db,$anggota['file-formulir']) ."',";
    $sql .= "now()";
    $sql .= ")";
    $result = mysqli_query($db, $sql);

    if ($result) {
      return true;
    } else {
      //INSERT Failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function anggota_masuk_find_all($limit){
    global $db;

    $sql = "SELECT no_anggota, nama_anggota, nik FROM anggota_masuk ";
    $sql .= "ORDER BY insert_date DESC LIMIT ".db_escape($db,$limit);
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  function anggota_masuk_find_one($id){
    global $db;

    $sql = "SELECT * FROM anggota_masuk ";
    $sql .= "WHERE no_anggota = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $data = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $data;
  }

  function anggota_masuk_update($id){
    global $db;

    $sql = "UPDATE anggota_masuk SET ";
    $sql .= "nama_anggota = '".db_escape($db,$_POST['nama'])."',";
    $sql .= "nik = '".db_escape($db,$_POST['nik'])."',";
    $sql .= "no_npwp = '".db_escape($db,$_POST['no-npwp'])."',";
    $sql .= "tanggal_lahir = '".db_escape($db,$_POST['tanggal-lahir'])."',";
    $sql .= "agama = '".db_escape($db,$_POST['agama'])."',";
    $sql .= "jenis_kelamin = '".db_escape($db,$_POST['jenis-kelamin'])."',";
    $sql .= "unit = '".db_escape($db,$_POST['unit'])."',";
    $sql .= "alamat = '".db_escape($db,$_POST['alamat'])."' ";
    $sql .= "WHERE no_anggota = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    if ($result) {
      return true;
    } else {
      //INSERT Failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function anggota_masuk_delete_one($id){
    global $db;

    $sql = "DELETE FROM anggota_masuk ";
    $sql .= "WHERE  no_anggota = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    if ($result) {
      return true;
    } else {
      //INSERT Failed
      return false;
    }
  }

  function anggota_masuk_search_data($query){
    global $db;

    $sql = "SELECT no_anggota, nama_anggota, nik FROM anggota_masuk ";
    $sql .= "WHERE nama_anggota LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR no_anggota LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR no_npwp LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR tanggal_lahir LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR jenis_kelamin LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR unit LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR alamat LIKE '%".db_escape($db,$query)."%' ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function anggota_keluar_insert_data($anggota){
    global $db;

    $sql = "INSERT INTO anggota_keluar (no_anggota, jumlah_simpanan, link_form_keluar, link_bukti_kirim, insert_date) ";
    $sql .= "VALUES (";
    $sql .= "'". db_escape($db,$anggota['no-urut']) ."',";
    $sql .= "'". db_escape($db,$anggota['jumlah-simpanan']) ."',";
    $sql .= "'". db_escape($db,$anggota['file-form']) ."',";
    $sql .= "'". db_escape($db,$anggota['file-bukti-bayar']) ."',";
    $sql .= "now()";
    $sql .= ")";
    $result = mysqli_query($db, $sql);

    if ($result) {
      return true;
    } else {
      //INSERT Failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  //DONE
  function anggota_keluar_find_all($limit){
    global $db;

    $sql = "SELECT anggota_keluar.no_anggota, nama_anggota, jumlah_simpanan FROM anggota_keluar ";
    $sql .= "INNER JOIN anggota_masuk ";
    $sql .= "ON anggota_masuk.no_anggota = anggota_keluar.no_anggota ";
    $sql .= "ORDER BY anggota_keluar.insert_date DESC LIMIT ".db_escape($db,$limit);
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function anggota_keluar_find_one($id){
    global $db;

    $sql = "SELECT anggota_keluar.no_anggota, nama_anggota, jumlah_simpanan, link_form_keluar, link_bukti_kirim FROM anggota_keluar ";
    $sql .= "INNER JOIN anggota_masuk ";
    $sql .= "ON anggota_masuk.no_anggota = anggota_keluar.no_anggota ";
    $sql .= "WHERE anggota_keluar.no_anggota = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $data = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $data;
  }

  //DONE
  function anggota_keluar_update($id){
    global $db;

    $sql = "UPDATE anggota_keluar SET ";
    $sql .= "jumlah_simpanan = '".db_escape($db,$_POST['jumlah_simpanan'])."' ";
    $sql .= "WHERE no_anggota = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    if ($result) {
      return true;
    } else {
      //INSERT Failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  //DONE
  function anggota_keluar_delete_one($id){
    global $db;

    $sql = "DELETE FROM anggota_keluar ";
    $sql .= "WHERE  no_anggota = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function anggota_keluar_search_data($query, $limit){
    global $db;

    $sql = "SELECT anggota_keluar.no_anggota, nama_anggota, jumlah_simpanan FROM anggota_keluar ";
    $sql .= "INNER JOIN anggota_masuk ";
    $sql .= "ON anggota_masuk.no_anggota = anggota_keluar.no_anggota ";
    $sql .= "WHERE anggota_keluar.no_anggota LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR nama_anggota LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR jumlah_simpanan LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR anggota_keluar.insert_date LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "LIMIT ".db_escape($db,$limit);
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function rekap_anggota_insert_data($anggota, $status){
    global $db;

    $sql = "INSERT INTO rekap_anggota (no_anggota, status, insert_date) ";
    $sql .= "VALUES (";
    $sql .= "'". db_escape($db,$anggota['no-urut']) ."',";
    $sql .= "'". db_escape($db,$status) ."', ";
    $sql .= "now()";
    $sql .= ")";
    $result = mysqli_query($db, $sql);

    if ($result) {
      return true;
    } else {
      //INSERT Failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  //DONE
  function rekap_anggota_update_data($no, $status){
    global $db;

    $sql = "UPDATE rekap_anggota SET ";
    $sql .= "status = '".db_escape($db,$status)."', ";
    $sql .= "insert_date = now() ";
    $sql .= "WHERE no_anggota = '".db_escape($db,$no)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    if ($result) {
      return true;
    } else {
      //INSERT Failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  //DONE
  function rekap_anggota_find_all($limit){
    global $db;

    $sql = "SELECT rekap_anggota.no_anggota, nama_anggota, nik, ";
    $sql .= "unit, anggota_masuk.insert_date AS 'Tanggal Masuk', anggota_keluar.insert_date AS 'Tanggal Keluar', status ";
    $sql .= "FROM rekap_anggota ";
    $sql .= "INNER JOIN anggota_masuk ON anggota_masuk.no_anggota = rekap_anggota.no_anggota ";
    $sql .= "LEFT JOIN anggota_keluar ON anggota_keluar.no_anggota = rekap_anggota.no_anggota ";
    $sql .= "LIMIT ".db_escape($db,$limit);
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function rekap_anggota_find_one($id){
    global $db;

    $sql = "SELECT rekap_anggota.no_anggota, nama_anggota, nik, ";
    $sql .= "unit, anggota_masuk.insert_date AS 'Tanggal Masuk', anggota_keluar.insert_date AS 'Tanggal Keluar', status ";
    $sql .= "FROM rekap_anggota ";
    $sql .= "INNER JOIN anggota_masuk ON anggota_masuk.no_anggota = rekap_anggota.no_anggota ";
    $sql .= "LEFT JOIN anggota_keluar ON anggota_keluar.no_anggota = rekap_anggota.no_anggota ";
    $sql .= "WHERE rekap_anggota.no_anggota = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function rekap_anggota_search_data($query, $limit){
    global $db;

    $sql = "SELECT rekap_anggota.no_anggota, nama_anggota, nik, ";
    $sql .= "unit, anggota_masuk.insert_date AS 'Tanggal Masuk', anggota_keluar.insert_date AS 'Tanggal Keluar', status ";
    $sql .= "FROM rekap_anggota ";
    $sql .= "INNER JOIN anggota_masuk ON anggota_masuk.no_anggota = rekap_anggota.no_anggota ";
    $sql .= "LEFT JOIN anggota_keluar ON anggota_keluar.no_anggota = rekap_anggota.no_anggota ";
    $sql .= "WHERE rekap_anggota.no_anggota LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR nama_anggota LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR nik LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR status LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "LIMIT ".db_escape($db,$limit);
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function simpanan_anggota_insert_data($anggota){
    global $db;

    $sql = "INSERT INTO simpanan_anggota (tanggal, no_anggota, simpanan_pokok, simpanan_wajib, simpanan_sukarela) ";
    $sql .= "VALUES (";
    $sql .= "now(), ";
    $sql .= "'".db_escape($db,$anggota['no-urut'])."', ";
    $sql .= "'".db_escape($db,$anggota['simpanan-pokok'])."', ";
    $sql .= "'".db_escape($db,$anggota['simpanan-wajib'])."', ";
    $sql .= "'".db_escape($db,$anggota['simpanan-sukarela'])."'";
    $sql .= ") ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    if ($result) {
      return true;
    } else {
      //INSERT Failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  //DONE
  function simpanan_anggota_find_all_index($limit){
    global $db;

    $sql = "SELECT id, simpanan_anggota.no_anggota, nama_anggota, simpanan_pokok, simpanan_wajib, simpanan_sukarela ";
    $sql .= "FROM simpanan_anggota INNER JOIN anggota_masuk ";
    $sql .= "ON anggota_masuk.no_anggota = simpanan_anggota.no_anggota ";
    $sql .= "ORDER BY simpanan_anggota.tanggal DESC ";
    $sql .= "LIMIT ".db_escape($db,$limit);
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function simpanan_anggota_search_data($query){
    global $db;

    $sql = "SELECT id, simpanan_anggota.no_anggota, nama_anggota, simpanan_pokok, simpanan_wajib, simpanan_sukarela ";
    $sql .= "FROM simpanan_anggota INNER JOIN anggota_masuk ";
    $sql .= "ON anggota_masuk.no_anggota = simpanan_anggota.no_anggota ";
    $sql .= "WHERE simpanan_anggota.no_anggota LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "ORDER BY simpanan_anggota.tanggal ASC ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function simpanan_anggota_count_data_by_id($query){
    global $db;

    $sql = "SELECT COUNT(*) AS count FROM simpanan_anggota ";
    $sql .= "INNER JOIN anggota_masuk ON anggota_masuk.no_anggota = simpanan_anggota.no_anggota ";
    $sql .= "WHERE simpanan_anggota.no_anggota LIKE '%".db_escape($db,$query)."%' ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function simpanan_anggota_find_one($id){
    global $db;

    $sql = "SELECT simpanan_anggota.no_anggota, nama_anggota, simpanan_pokok, simpanan_wajib, simpanan_sukarela ";
    $sql .= "FROM simpanan_anggota INNER JOIN anggota_masuk ";
    $sql .= "ON anggota_masuk.no_anggota = simpanan_anggota.no_anggota ";
    $sql .= "WHERE simpanan_anggota.id = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $data = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $data;
  }

  //DONE
  function simpanan_anggota_update_data($no, $data){
    global $db;

    $sql = "UPDATE simpanan_anggota SET ";
    $sql .= "simpanan_pokok = '".db_escape($db,$data['simpanan-pokok'])."', ";
    $sql .= "simpanan_wajib = '".db_escape($db,$data['simpanan-wajib'])."', ";
    $sql .= "simpanan_sukarela = '".db_escape($db,$data['simpanan-sukarela'])."', ";
    $sql .= "tanggal = now() ";
    $sql .= "WHERE id = '".db_escape($db,$no)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    if ($result) {
      return true;
    } else {
      //INSERT Failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  //DONE
  function simpanan_anggota_delete_one($id){
    global $db;

    $sql = "DELETE FROM simpanan_anggota ";
    $sql .= "WHERE id = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function pembayaran_pinjam_find_all_index($limit){
    global $db;

    $sql = "SELECT id, tanggal, pembayaran_pinjam.no_anggota, nama_anggota, pembayaran_bulan, pokok_pinjaman, bagi_hasil, ujrah ";
    $sql .= "FROM pembayaran_pinjam INNER JOIN anggota_masuk ";
    $sql .= "ON anggota_masuk.no_anggota = pembayaran_pinjam.no_anggota ";
    $sql .= "ORDER BY pembayaran_pinjam.tanggal DESC ";
    $sql .= "LIMIT ".db_escape($db,$limit);
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function pembayaran_pinjam_insert_data($anggota){
    global $db;

    $sql = "INSERT INTO pembayaran_pinjam (tanggal, no_anggota, pembayaran_bulan, pokok_pinjaman, bagi_hasil, ujrah) ";
    $sql .= "VALUES (";
    $sql .= "now(), ";
    $sql .= "'".db_escape($db,$anggota['no-urut'])."', ";
    $sql .= "'".db_escape($db,$anggota['pembayaran-bulan'])."', ";
    $sql .= "'".db_escape($db,$anggota['pokok-pinjaman'])."', ";
    $sql .= "'".db_escape($db,$anggota['bagi-hasil'])."', ";
    $sql .= "'".db_escape($db,$anggota['ujrah'])."'";
    $sql .= ") ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    if ($result) {
      return true;
    } else {
      //INSERT Failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  //DONE
  function pembayaran_pinjam_update_data($no, $data){
    global $db;

    $sql = "UPDATE pembayaran_pinjam SET ";
    $sql .= "pembayaran_bulan = '".db_escape($db,$data['pembayaran-bulan'])."', ";
    $sql .= "pokok_pinjaman = '".db_escape($db,$data['pokok-pinjaman'])."', ";
    $sql .= "bagi_hasil = '".db_escape($db,$data['bagi-hasil'])."', ";
    $sql .= "ujrah = '".db_escape($db,$data['ujrah'])."' ";
    $sql .= "WHERE id = '".db_escape($db,$no)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    if ($result) {
      return true;
    } else {
      //INSERT Failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  //DONE
  function pembayaran_pinjam_find_one($id){
    global $db;

    $sql = "SELECT pembayaran_pinjam.no_anggota, nama_anggota, pembayaran_bulan, pokok_pinjaman, bagi_hasil, ujrah ";
    $sql .= "FROM pembayaran_pinjam INNER JOIN anggota_masuk ";
    $sql .= "ON anggota_masuk.no_anggota = pembayaran_pinjam.no_anggota ";
    $sql .= "WHERE pembayaran_pinjam.id = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $data = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $data;
  }

  //DONE
  function pembayaran_pinjam_search_data($query){
    global $db;

    $sql = "SELECT id, pembayaran_pinjam.no_anggota, nama_anggota, pembayaran_bulan, pokok_pinjaman, bagi_hasil, ujrah ";
    $sql .= "FROM pembayaran_pinjam INNER JOIN anggota_masuk ";
    $sql .= "ON anggota_masuk.no_anggota = pembayaran_pinjam.no_anggota ";
    $sql .= "WHERE pembayaran_pinjam.no_anggota LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "ORDER BY pembayaran_pinjam.tanggal ASC ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function pembayaran_pinjam_count_data_by_id($query){
    global $db;

    $sql = "SELECT COUNT(*) AS count FROM pembayaran_pinjam ";
    $sql .= "INNER JOIN anggota_masuk ON anggota_masuk.no_anggota = pembayaran_pinjam.no_anggota ";
    $sql .= "WHERE pembayaran_pinjam.no_anggota LIKE '%".db_escape($db,$query)."%' ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function pembayaran_pinjam_delete_one($id){
    global $db;

    $sql = "DELETE FROM pembayaran_pinjam ";
    $sql .= "WHERE id = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function pembayaran_lainnya_find_all_index($limit){
    global $db;

    $sql = "SELECT * ";
    $sql .= "FROM pembayaran_lainnya ";
    $sql .= "ORDER BY insert_date DESC ";
    $sql .= "LIMIT ".db_escape($db,$limit);
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function pembayaran_lainnya_insert_data($anggota){
    global $db;

    $sql = "INSERT INTO pembayaran_lainnya (no_kwitansi_penerimaan, uraian, jumlah, insert_date) ";
    $sql .= "VALUES (";
    $sql .= "'".db_escape($db,$anggota['no-kwitansi'])."', ";
    $sql .= "'".db_escape($db,$anggota['uraian'])."', ";
    $sql .= "'".db_escape($db,$anggota['jumlah'])."', ";
    $sql .= "now() ";
    $sql .= ") ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    if ($result) {
      return true;
    } else {
      //INSERT Failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  //DONE
  function pembayaran_lainnya_find_one($id){
    global $db;

    $sql = "SELECT * ";
    $sql .= "FROM pembayaran_lainnya ";
    $sql .= "WHERE id = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $data = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $data;
  }

  //DONE
  function pembayaran_lainnya_update_data($no, $data){
    global $db;

    $sql = "UPDATE pembayaran_lainnya SET ";
    $sql .= "uraian = '".db_escape($db,$data['uraian'])."', ";
    $sql .= "no_kwitansi_penerimaan = '".db_escape($db,$data['no-kwitansi'])."', ";
    $sql .= "jumlah = '".db_escape($db,$data['jumlah'])."' ";
    $sql .= "WHERE id = '".db_escape($db,$no)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    if ($result) {
      return true;
    } else {
      //INSERT Failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  //DONE
  function pembayaran_lainnya_search_data($query){
    global $db;

    $sql = "SELECT id, no_kwitansi_penerimaan, uraian, jumlah, insert_date ";
    $sql .= "FROM pembayaran_lainnya ";
    $sql .= "WHERE no_kwitansi_penerimaan LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR uraian LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR insert_date LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "ORDER BY insert_date ASC ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function pembayaran_lainnya_count_data_by_id($query){
    global $db;

    $sql = "SELECT COUNT(*) AS count FROM pembayaran_lainnya ";
    $sql .= "WHERE no_kwitansi_penerimaan LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR uraian LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR insert_date LIKE '%".db_escape($db,$query)."%' ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function pembayaran_lainnya_delete_one($id){
    global $db;

    $sql = "DELETE FROM pembayaran_lainnya ";
    $sql .= "WHERE id = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function pembayaran_pinjaman_anggota_find_all_index($limit){
    global $db;

    $sql = "SELECT id, pembayaran_pinjaman_anggota.insert_date, kode_transaksi, pembayaran_pinjaman_anggota.no_anggota, nama_anggota, ";
    $sql .= "lama_pinjaman, jumlah_pinjaman ";
    $sql .= "FROM pembayaran_pinjaman_anggota ";
    $sql .= "INNER JOIN anggota_masuk ";
    $sql .= "ON anggota_masuk.no_anggota = pembayaran_pinjaman_anggota.no_anggota ";
    $sql .= "ORDER BY pembayaran_pinjaman_anggota.insert_date DESC ";
    $sql .= "LIMIT ".db_escape($db,$limit);
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function pembayaran_pinjaman_anggota_search_data($query){
    global $db;

    $sql = "SELECT id, pembayaran_pinjaman_anggota.insert_date, kode_transaksi, pembayaran_pinjaman_anggota.no_anggota, nama_anggota, ";
    $sql .= "lama_pinjaman, jumlah_pinjaman ";
    $sql .= "FROM pembayaran_pinjaman_anggota ";
    $sql .= "INNER JOIN anggota_masuk ";
    $sql .= "ON anggota_masuk.no_anggota = pembayaran_pinjaman_anggota.no_anggota ";
    $sql .= "WHERE kode_transaksi LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR nama_anggota LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR pembayaran_pinjaman_anggota.no_anggota LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR lama_pinjaman LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR pembayaran_pinjaman_anggota.insert_date LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "ORDER BY pembayaran_pinjaman_anggota.insert_date ASC ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function pembayaran_pinjaman_anggota_find_one($id){
    global $db;

    $sql = "SELECT id, pembayaran_pinjaman_anggota.insert_date, kode_transaksi, pembayaran_pinjaman_anggota.no_anggota, nama_anggota, ";
    $sql .= "lama_pinjaman, jumlah_pinjaman, pembayaran_pinjaman_anggota.link_formulir, link_bukti_bayar, folder ";
    $sql .= "FROM pembayaran_pinjaman_anggota ";
    $sql .= "INNER JOIN anggota_masuk ";
    $sql .= "ON anggota_masuk.no_anggota = pembayaran_pinjaman_anggota.no_anggota ";
    $sql .= "WHERE id = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $data = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $data;
  }

  //DONE
  function pembayaran_pinjaman_anggota_insert_data($anggota){
    global $db;

    $sql = "INSERT INTO pembayaran_pinjaman_anggota (insert_date, kode_transaksi, no_anggota, lama_pinjaman, jumlah_pinjaman, link_formulir, link_bukti_bayar, folder) ";
    $sql .= "VALUES (";
    $sql .= "now(),";
    $sql .= "'". db_escape($db,$anggota['kode-transaksi']) ."',";
    $sql .= "'". db_escape($db,$anggota['no-urut']) ."',";
    $sql .= "'". db_escape($db,$anggota['lama-pinjaman']) ."',";
    $sql .= "'". db_escape($db,$anggota['jumlah-pinjaman']) ."',";
    $sql .= "'". db_escape($db,$anggota['file-formulir']) ."',";
    $sql .= "'". db_escape($db,$anggota['file-bukti-bayar']) ."', ";
    $sql .= "'". db_escape($db,$anggota['folder']) ."' ";
    $sql .= ") ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    if ($result) {
      return true;
    } else {
      //INSERT Failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  //DONE
  function pembayaran_pinjaman_anggota_update($id){
    global $db;

    $sql = "UPDATE pembayaran_pinjaman_anggota SET ";
    $sql .= "kode_transaksi = '".db_escape($db,$_POST['kode-transaksi'])."',";
    $sql .= "lama_pinjaman = '".db_escape($db,$_POST['lama-pinjaman'])."',";
    $sql .= "jumlah_pinjaman = '".db_escape($db,$_POST['jumlah-pinjaman'])."' ";
    $sql .= "WHERE id = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);

    if ($result) {
      return true;
    } else {
      //INSERT Failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  //DONE
  function pembayaran_pinjaman_anggota_delete_one($id){
    global $db;

    $sql = "DELETE FROM pembayaran_pinjaman_anggota ";
    $sql .= "WHERE id = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function pembayaran_pajak_find_all_index($limit){
    global $db;

    $sql = "SELECT * ";
    $sql .= "FROM pembayaran_pajak ";
    $sql .= "ORDER BY insert_date DESC ";
    $sql .= "LIMIT ".db_escape($db,$limit);
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function pembayaran_pajak_search_data($query){
    global $db;

    $sql = "SELECT * ";
    $sql .= "FROM pembayaran_pajak ";
    $sql .= "WHERE kode_transaksi LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR jenis_pajak LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR insert_date LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "ORDER BY insert_date ASC ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function pembayaran_pajak_insert_data($anggota){
    global $db;

    $sql = "INSERT INTO pembayaran_pajak (insert_date, jenis_pajak, kode_transaksi, jumlah, link_bill_pajak, link_bukti_bayar) ";
    $sql .= "VALUES (";
    $sql .= "now(),";
    $sql .= "'". db_escape($db,$anggota['jenis-pajak']) ."',";
    $sql .= "'". db_escape($db,$anggota['kode-transaksi']) ."',";
    $sql .= "'". db_escape($db,$anggota['jumlah']) ."',";
    $sql .= "'". db_escape($db,$anggota['file-bill-pajak']) ."',";
    $sql .= "'". db_escape($db,$anggota['file-bukti-bayar']) ."' ";
    $sql .= ") ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    if ($result) {
      return true;
    } else {
      //INSERT Failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  //DONE
  function pembayaran_pajak_count_data(){
    global $db;

    $sql = "SELECT max(id) as count FROM pembayaran_pajak";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $data = mysqli_fetch_assoc($result);
    return $data;
  }

  //DONE
  function pembayaran_pajak_find_one($id){
    global $db;

    $sql = "SELECT * ";
    $sql .= "FROM pembayaran_pajak ";
    $sql .= "WHERE id = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $data = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $data;
  }

  //DONE
  function pembayaran_pajak_update($id){
    global $db;

    $sql = "UPDATE pembayaran_pajak SET ";
    $sql .= "jenis_pajak = '".db_escape($db,$_POST['jenis-pajak'])."', ";
    $sql .= "kode_transaksi = '".db_escape($db,$_POST['kode-transaksi'])."', ";
    $sql .= "jumlah = '".db_escape($db,$_POST['jumlah'])."' ";
    $sql .= "WHERE id = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    if ($result) {
      return true;
    } else {
      //INSERT Failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  //DONE
  function pembayaran_pajak_delete_one($id){
    global $db;

    $sql = "DELETE FROM pembayaran_pajak ";
    $sql .= "WHERE id = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function pembayaran_anggota_keluar_find_all_index($limit){
    global $db;

    $sql = "SELECT id, pembayaran_anggota_keluar.insert_date, kode_transaksi, pembayaran_anggota_keluar.no_anggota, nama_anggota, ";
    $sql .= "jumlah, folder ";
    $sql .= "FROM pembayaran_anggota_keluar ";
    $sql .= "INNER JOIN anggota_masuk ";
    $sql .= "ON anggota_masuk.no_anggota = pembayaran_anggota_keluar.no_anggota ";
    $sql .= "ORDER BY pembayaran_anggota_keluar.insert_date DESC ";
    $sql .= "LIMIT ".db_escape($db,$limit);
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function pembayaran_anggota_keluar_search_data($query){
    global $db;

    $sql = "SELECT id, pembayaran_anggota_keluar.insert_date, kode_transaksi, pembayaran_anggota_keluar.no_anggota, nama_anggota, ";
    $sql .= "jumlah ";
    $sql .= "FROM pembayaran_anggota_keluar ";
    $sql .= "INNER JOIN anggota_masuk ";
    $sql .= "ON anggota_masuk.no_anggota = pembayaran_anggota_keluar.no_anggota ";
    $sql .= "WHERE kode_transaksi LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR nama_anggota LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR pembayaran_anggota_keluar.no_anggota LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR pembayaran_anggota_keluar.insert_date LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "ORDER BY pembayaran_anggota_keluar.insert_date ASC ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function pembayaran_anggota_keluar_find_one($id){
    global $db;

    $sql = "SELECT id, Pembayaran_anggota_keluar.insert_date, kode_transaksi, Pembayaran_anggota_keluar.no_anggota, nama_anggota, ";
    $sql .= "jumlah, link_pembayaran_anggota_keluar, link_bukti_bayar, folder ";
    $sql .= "FROM Pembayaran_anggota_keluar ";
    $sql .= "INNER JOIN anggota_masuk ";
    $sql .= "ON anggota_masuk.no_anggota = Pembayaran_anggota_keluar.no_anggota ";
    $sql .= "WHERE id = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $data = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $data;
  }

  //DONE
  function pembayaran_anggota_keluar_insert_data($anggota){
    global $db;

    $sql = "INSERT INTO pembayaran_anggota_keluar (insert_date, kode_transaksi, no_anggota, jumlah, link_pembayaran_anggota_keluar, link_bukti_bayar, folder) ";
    $sql .= "VALUES (";
    $sql .= "now(),";
    $sql .= "'". db_escape($db,$anggota['kode-transaksi']) ."',";
    $sql .= "'". db_escape($db,$anggota['no-urut']) ."',";
    $sql .= "'". db_escape($db,$anggota['jumlah']) ."',";
    $sql .= "'". db_escape($db,$anggota['file-pembayaran-anggota-keluar']) ."',";
    $sql .= "'". db_escape($db,$anggota['file-bukti-bayar']) ."', ";
    $sql .= "'". db_escape($db,$anggota['folder']) ."' ";
    $sql .= ") ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    if ($result) {
      return true;
    } else {
      //INSERT Failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  //DONE
  function pembayaran_anggota_keluar_update($id){
    global $db;

    $sql = "UPDATE pembayaran_anggota_keluar SET ";
    $sql .= "kode_transaksi = '".db_escape($db,$_POST['kode-transaksi'])."' ";
    $sql .= "WHERE id = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    if ($result) {
      return true;
    } else {
      //INSERT Failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  //DONE
  function simpanan_anggota_get_total($id){
    global $db;

    $sql = "SELECT (SUM(simpanan_pokok)+SUM(simpanan_wajib)+SUM(simpanan_sukarela)) AS total ";
    $sql .= "FROM simpanan_anggota WHERE no_anggota = '".db_escape($db,$id)."' ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $data = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $data;
  }

  //DONE
  function pembayaran_anggota_keluar_delete_one($id){
    global $db;

    $sql = "DELETE FROM pembayaran_anggota_keluar ";
    $sql .= "WHERE id = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function belanja_operasional_find_all_index($limit){
    global $db;

    $sql = "SELECT * ";
    $sql .= "FROM belanja_operasional ";
    $sql .= "ORDER BY insert_date DESC ";
    $sql .= "LIMIT ".db_escape($db,$limit);
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function belanja_operasional_search_data($query){
    global $db;

    $sql = "SELECT * ";
    $sql .= "FROM belanja_operasional ";
    $sql .= "WHERE kode_transaksi LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR uraian_belanja LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "OR insert_date LIKE '%".db_escape($db,$query)."%' ";
    $sql .= "ORDER BY insert_date ASC ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  //DONE
  function belanja_operasional_count_data(){
    global $db;

    $sql = "SELECT max(id) as count FROM belanja_operasional";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $data = mysqli_fetch_assoc($result);
    return $data;
  }

  //DONE
  function belanja_operasional_insert_data($anggota){
    global $db;

    $sql = "INSERT INTO belanja_operasional (insert_date, kode_transaksi, uraian_belanja, jumlah, link_kwitansi) ";
    $sql .= "VALUES (";
    $sql .= "now(),";
    $sql .= "'". db_escape($db,$anggota['kode-transaksi']) ."',";
    $sql .= "'". db_escape($db,$anggota['uraian-belanja']) ."',";
    $sql .= "'". db_escape($db,$anggota['jumlah']) ."',";
    $sql .= "'". db_escape($db,$anggota['file-kwitansi']) ."' ";
    $sql .= ") ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    if ($result) {
      return true;
    } else {
      //INSERT Failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  //DONE
  function belanja_operasional_find_one($id){
    global $db;

    $sql = "SELECT * ";
    $sql .= "FROM belanja_operasional ";
    $sql .= "WHERE id = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $data = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $data;
  }

  //DONE
  function belanja_operasional_update($id){
    global $db;

    $sql = "UPDATE belanja_operasional SET ";
    $sql .= "uraian_belanja = '".db_escape($db,$_POST['uraian-belanja'])."', ";
    $sql .= "kode_transaksi = '".db_escape($db,$_POST['kode-transaksi'])."', ";
    $sql .= "jumlah = '".db_escape($db,$_POST['jumlah'])."' ";
    $sql .= "WHERE id = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    if ($result) {
      return true;
    } else {
      //INSERT Failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  //
  function belanja_operasional_delete_one($id){
    global $db;

    $sql = "DELETE FROM belanja_operasional ";
    $sql .= "WHERE id = '".db_escape($db,$id)."' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
 ?>
