<?php
require_once('../private/initialize.php');

$page_title = "ACCOUNT SETTING";
$app_css = "stylesheets/app.css";


require_once(SHARED_PATH . '/app_header.php');
$hidden_button = "";
if ($user_status != "admin") {
  $hidden_button = "hidden";
}

?>
<div class="row">
  <div class="col"></div>
  <div class="col-sm-6">
    <h1 id="page-title" class="border border-5 border-primary custom-round"><?php echo $_SESSION['username']; ?></h1>
    <div class="card card-wrapping">
      <div class="btn-group-vertical" role="group" aria-label="Basic outlined example">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#changePassword">Ganti Password</button>
        <!-- Modal -->
        <div class="modal fade" id="changePassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ganti Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method="post" action="<?php echo url_for("/account/password_change.php"); ?>">
               <div class="mb-3">
                 <label for="inputUsername" class="form-label">Password Lama</label>
                 <input type="password" class="form-control <?php echo $invalid; ?>" id="InputPassword" aria-describedby="usernameHelp" name="password-old" required>
               </div>
               <div class="mb-3">
                 <label for="exampleInputPassword1" class="form-label">Password Baru</label>
                 <input type="password" class="form-control <?php echo $invalid; ?>" id="InputPasswordNew" name="password-new" required>
               </div>
               <div class="mb-3">
                 <label for="exampleInputPassword1" class="form-label">Konfirmasi Password Baru</label>
                 <input type="password" class="form-control <?php echo $invalid; ?>" id="InputPasswordNew1" name="password-new-1" required>
               </div>
               <button type="submit" class="btn btn-primary" id="submit_change_password" hidden>Submit</button>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
            </div>
          </div>
        </div>

        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addAccount" <?php echo $hidden_button; ?>>Tambah Akun</button>
        <!-- Modal -->
        <div class="modal fade" id="addAccount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" <?php echo $hidden_button; ?>>
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method="post" action="<?php echo url_for("/account/add_account.php"); ?>">
               <div class="mb-3">
                 <label for="inputUsername" class="form-label">Username</label>
                 <input type="text" class="form-control <?php echo $invalid; ?>" id="inputUsername" aria-describedby="usernameHelp" name="username" required>
               </div>
               <div class="mb-3">
                 <label for="exampleInputPassword1" class="form-label">Password</label>
                 <input type="password" class="form-control <?php echo $invalid; ?>" id="InputPasswordNewUser" name="password-new-user" required>
               </div>
               <div class="mb-3">
                 <label for="exampleInputPassword1" class="form-label">Konfirmasi Password</label>
                 <input type="password" class="form-control <?php echo $invalid; ?>" id="InputPasswordNewUser1" name="password-new-user-1" required>
               </div>
               <div class="mb-3">
                 <label for="" class="form-label">Tipe User</label>
                 <select class="form-select" aria-label="Default select example" name="tipe-user">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                  </select></div>
               <button type="submit" class="btn btn-primary" id="submit_new_user">Submit</button>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
            </div>
          </div>
        </div>
        <button type="button" class="btn btn-outline-primary" id="logout_button">Log Out</button>
      </div>
    </div>
  </div>
  <div class="col"></div>
</div>

<script type="text/javascript" src="<?php echo url_for('/js/account_settings.js'); ?>"></script>
<?php require_once(SHARED_PATH . '/app_footer.php'); ?>
