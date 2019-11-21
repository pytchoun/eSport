<?php
include "$_SERVER[DOCUMENT_ROOT]/theme/head.php";
include "$_SERVER[DOCUMENT_ROOT]/theme/sidebar.php";
include "$_SERVER[DOCUMENT_ROOT]/theme/navbar.php";
?>

<!-- Main Content -->
<main>
  <!-- Container Content -->
  <div class="container">
    <!-- Row Content -->
    <div class="row">

      <!-- Col -->
      <div class="col">

        <?php if ($coupon) { ?>
          <!-- Form -->
          <form method="POST" action="">
            <input type="hidden" name="token" value="<?php echo $token; ?>">

            <!-- Card -->
            <div class="card">
              <h5 class="card-header">Recover your <?php echo $site_name; ?> account</h5>

              <!-- Card Body -->
              <div class="card-body">

                <!-- Form Group -->
                <div class="form-group">
                  <label for="password">New password <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="Your password must be between 8 and 72 characters long."></i></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" class="form-control input-color" id="password" name="new-password" minlength="8" maxlength="72" placeholder="Your new password" required>
                  </div>
                  <span class="text-danger"><?php if (isset($_SESSION['errors']['new_password'])) echo $_SESSION['errors']['new_password']; ?></span>
                </div>
                <!-- Form Group -->

                <!-- Form Group -->
                <div class="form-group">
                  <label for="ConfirmPassword">Confirm new password</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" class="form-control input-color" id="ConfirmPassword" name="confirm-new-password" minlength="8" maxlength="72" placeholder="Confirm your new password" required>
                  </div>
                  <span class="text-danger"><?php if (isset($_SESSION['errors']['confirm_new_password'])) echo $_SESSION['errors']['confirm_new_password']; ?></span>
                </div>
                <!-- Form Group -->

                <div class="row mt-3 justify-content-center">
                  <div class="col-6">
                    <button type="submit" class="btn btn-primary btn-block" name="confirm-password">Reset password</button>
                  </div>
                </div>

              </div>
              <!-- Card Body -->

            </div>
            <!-- Card -->

          </form>
          <!-- Form -->
        <?php } else { ?>
          <!-- Coupon is invalid -->
          <!-- Alert -->
          <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">The coupon is invalid</h4>
            <p>
              The coupon is invalid or has expired. <br>
              If you encounter problems, <a href="/contact">contact us</a>.
            </p>
          </div>
          <!-- Alert -->
          <!-- Coupon is invalid -->
        <?php } ?>

      </div>
      <!-- Col -->

    </div>
    <!-- Row Content -->
  </div>
  <!-- Container Content -->
</main>
<!-- Main Content -->

<?php include "$_SERVER[DOCUMENT_ROOT]/theme/footer.php"; ?>
