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

        <?php if (isset($_SESSION['notification']['login']['error'])) { ?>
          <!-- Account is not found -->
          <!-- Alert -->
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Account is not found</h4>
            <p>
              If you encounter problems, <a href="/contact">contact us</a>.
            </p>

            <hr>

            <button type="button" class="btn btn-primary" data-dismiss="alert">Ok !</button>
          </div>
          <!-- Alert -->
          <!-- Account is not found -->
        <?php } ?>

        <?php if (isset($_SESSION['notification']['email'])) { ?>
          <!-- Password reset request sent -->
          <!-- Alert -->
          <div class="alert alert-info alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Password reset request sent</h4>
            <p>
              Reset your password by following the link received by email.
            </p>

            <hr>

            <button type="button" class="btn btn-primary" data-dismiss="alert">I will look at my emails</button>
          </div>
          <!-- Alert -->
          <!-- Password reset request sent -->
        <?php } ?>

        <!-- Form -->
        <form method="POST" action="">
          <input type="hidden" name="token" value="<?php echo $token; ?>">

          <!-- Card -->
          <div class="card">
            <h5 class="card-header">Reset your <?php echo $site_name; ?> account password</h5>

            <!-- Card Body -->
            <div class="card-body">

              <!-- Form Group -->
              <div class="form-group">
                <label for="email">Email address</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                  </div>
                  <input type="email" class="form-control input-color" id="email" name="email" placeholder="Enter the email address of your account" required>
                </div>
              </div>
              <!-- Form Group -->

              <!-- Row -->
              <div class="row mt-3 justify-content-center">

                <!-- Col Content -->
                <div class="col-6">
                  <button type="submit" class="btn btn-primary btn-block" name="reset-password" aria-describedby="loginHelp">Reset password</button>

                  <small id="loginHelp" class="form-text text-center">
                    <a href="/register">No account ? Click here.</a>
                  </small>
                </div>
                <!-- Col Content -->

              </div>
              <!-- Row -->

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
