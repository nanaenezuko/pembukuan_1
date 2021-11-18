<?php
require_once('../private/initialize.php');

$page_title = "ACCOUNT SETTING";
$app_css = "stylesheets/app.css";
$message = "*Berhasil Menambah Akun";
$color = "";


require_once(SHARED_PATH . '/app_header.php');
if (is_post_request() && $user_status == "admin") {
  if ($_POST['password-new-user-1'] == $_POST['password-new-user']) {
    $data['username'] = $_POST['username'];
    $data['password'] = $_POST['password-new-user-1'];
    $data['level'] = $_POST['tipe-user'];

    insert_userdata($data);
  } else {
    $message = "*Membuat Akun Gagal";
    $color = "red";
  }

} else {
  redirect_to(url_for("/account/account_settings.php"));
}

?>

<div class="card card-wrapping">
  <h1 style="color: <?php echo $color; ?>";><?php echo $message; ?></h1>
  <div class="row">
    <div class="col"></div>
    <div class="col-md-4">
      <div class="d-grid gap-2 col-6 mx-auto">
        <button type="button" name="button" class="btn btn-primary text-white" id="btn_ok_redirect"> <h5>OK</h5> </button>
      </div>
    </div>
    <div class="col"></div>
  </div>
</div>

<script type="text/javascript" src="<?php echo url_for('/js/account_settings.js'); ?>"></script>

<?php require_once(SHARED_PATH . '/app_footer.php'); ?>
