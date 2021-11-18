<?php
require_once('private/initialize.php');

$page_title = "ERROR";
$app_css = "stylesheets/app.css";
if ($_SERVER['REQUEST_URI'] == "/") {
  redirect_to(url_for(""));
}
require_once('private/shared/app_header.php');

?>

<h2>Error : Halaman Tidak Ditemukan</h2>

<?php require_once('private/shared/app_footer.php'); ?>
