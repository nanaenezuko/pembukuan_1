<?php
require_once('../private/initialize.php');

$page_title = "ACCOUNT SETTING";
$app_css = "stylesheets/app.css";
$message = "*Password Change Success";
$color = "";

require_once(SHARED_PATH . '/app_header.php');

if (is_post_request()) {
  $userdata = get_userdata($_SESSION['username']);

  if ($userdata['password'] == $_POST['password-old']) {
    update_userdata($_SESSION['username'], $_POST['password-new-1']);
  } else {
    $message = "*Password Lama Salah";
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
