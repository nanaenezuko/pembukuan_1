<?php
require_once('../private/initialize.php');

$page_title = "ERROR";
$app_css = "stylesheets/app.css";

require_once(SHARED_PATH . "/app_header.php");

session_unset();
session_destroy();
redirect_to(url_for("/account/login.php"));

?>

<?php require_once(SHARED_PATH .'app_footer.php'); ?>
