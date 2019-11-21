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
      <!-- Col Content -->
      <div class="col">

        <?php if (isset($_SESSION['notification']['registration'])) { ?>
          <!-- Account is created -->
          <!-- Alert -->
          <div class="alert alert-info alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Account is created</h4>
            <p>
              Activate your account by following the link received by email.
            </p>

            <hr>

            <button type="button" class="btn btn-primary" data-dismiss="alert">I will look at my emails</button>
          </div>
          <!-- Alert -->
          <!-- Account is created -->
        <?php } ?>

        <?php if (isset($_SESSION['login']['activation'])) { ?>
          <!-- Account is not activated -->
          <!-- Alert -->
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Account is not activated</h4>
            <p>
              You must activate your account, check your emails. <br>
              If you encounter problems, <a href="/contact">contact us</a>.
            </p>

            <hr>

            <form method="POST" action="">
              <input type="hidden" name="token" value="<?php echo $token; ?>">
              <input type="hidden" name="email" value="<?php echo $_SESSION['login']['user_email']; ?>">
              <input type="hidden" name="user-id" value="<?php echo $_SESSION['login']['user_id']; ?>">

              <button type="submit" class="btn btn-primary" name="resend-email">Resend an activation email</button>
              <button type="button" class="btn btn-secondary" data-dismiss="alert">I will look at my emails</button>
            </form>
          </div>
          <!-- Alert -->
          <!-- Account is not activated -->
        <?php } ?>

        <?php if (isset($_SESSION['resetPassword']['success'])) {
          unset($_SESSION['resetPassword']['success']);
          ?>
          <!-- Password reset with success -->
          <!-- Alert -->
          <div class="alert alert-info alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Password reset with success</h4>
            <p>
              You can login.
            </p>

            <hr>

            <button type="button" class="btn btn-primary" data-dismiss="alert">Ok !</button>
          </div>
          <!-- Alert -->
          <!-- Password reset with success -->
        <?php } ?>

        <!-- Form -->
        <form method="POST" action="">
          <input type="hidden" name="token" value="<?php echo $token; ?>">

          <!-- Card -->
          <div class="card">
            <h5 class="card-header">Login to your <?php echo $site_name; ?> account</h5>

            <!-- Card Body -->
            <div class="card-body">

              <!-- Email address -->
              <div class="form-group">
                <label for="email">Email address</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                  </div>
                  <input type="email" class="form-control input-color" id="email" name="email" placeholder="Your email address" required>
                </div>
              </div>
              <!-- Email address -->

              <!-- Password -->
              <div class="form-group">
                <label for="password">Password</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                  </div>
                  <input type="password" class="form-control input-color" id="password" name="password" minlength="8" maxlength="72" placeholder="Your password" required>
                </div>
              </div>
              <!-- Password -->

              <!-- Remember me -->
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" value="checked" id="remember" name="remember-me">
                <label class="custom-control-label" for="remember">
                  Remember me
                </label>
                <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="We will create cookies on your computer to save your session when you come back for 30 days."></i>
              </div>
              <!-- Remember me -->

              <!-- Row Content -->
              <div class="row mt-3 justify-content-center">

                <!-- Col Content -->
                <div class="col-6">
                  <button type="submit" class="btn btn-primary btn-block" name="login" aria-describedby="loginLost">Login</button>

                  <small id="loginLost" class="form-text text-center">
                    <a href="/reset-password">Lost your password ?</a>
                  </small>

                  <small id="loginHelp" class="form-text text-center">
                    <a href="/register">No account ? Click here.</a>
                  </small>
                </div>
                <!-- Col Content -->

              </div>
              <!-- Row Content -->

            </div>
            <!-- Card Body -->

          </div>
          <!-- Card -->

        </form>
        <!-- Form -->

      </div>
      <!-- Col Content -->
    </div>
    <!-- Row Content -->
  </div>
  <!-- Container Content -->
</main>
<!-- Main Content -->

<?php include "$_SERVER[DOCUMENT_ROOT]/theme/footer.php"; ?>
