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

        <!-- Form -->
        <form method="POST" action="">
          <input type="hidden" name="token" value="<?php echo $token; ?>">

          <!-- Card -->
          <div class="card">
            <h5 class="card-header">Create a <?php echo $site_name; ?> account</h5>

            <!-- Card Body -->
            <div class="card-body">

              <label for="email">Email address</label>
              <!-- Form Row -->
              <div class="form-row">

                <!-- Form Group (Email Adress) -->
                <div class="form-group col">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" class="form-control input-color" id="email" name="email" placeholder="Your email address" value="<?php if (isset($_POST['email'])) echo verifyInput($_POST['email']); ?>" required>
                  </div>
                  <span class="text-danger"><?php if (isset($_SESSION['errors']['email'])) echo $_SESSION['errors']['email']; ?></span>
                </div>
                <!-- Form Group (Email Adress) -->

                <!-- Form Group (Confirmation Email Adress) -->
                <div class="form-group col">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" class="form-control input-color" id="confirmEmail" name="confirm-email" placeholder="Retype your email address" value="<?php if (isset($_POST['confirm-email'])) echo verifyInput($_POST['confirm-email']); ?>" required>
                  </div>
                  <span class="text-danger"><?php if (isset($_SESSION['errors']['confirm_email'])) echo $_SESSION['errors']['confirm_email']; ?></span>
                </div>
                <!-- Form Group (Confirmation Email Adress) -->

              </div>
              <!-- Form Row -->

              <label for="password">Password <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="Your password must be between 8 and 72 characters long."></i></label>
              <!-- Form Row -->
              <div class="form-row">

                <!-- Form Group (Password) -->
                <div class="form-group col">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" class="form-control input-color" id="password" name="password" minlength="8" maxlength="72" placeholder="Your password" required>
                  </div>
                  <span class="text-danger"><?php if (isset($_SESSION['errors']['password'])) echo $_SESSION['errors']['password']; ?></span>
                </div>
                <!-- Form Group (Password) -->

                <!-- Form Group (Confirmation Password) -->
                <div class="form-group col">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" class="form-control input-color" id="confirmPassword" name="confirm-password" minlength="8" maxlength="72" placeholder="Retype your password" required>
                  </div>
                  <span class="text-danger"><?php if (isset($_SESSION['errors']['confirm_password'])) echo $_SESSION['errors']['confirm_password']; ?></span>
                </div>
                <!-- Form Group (Confirmation Password) -->

              </div>
              <!-- Form Row -->

              <!-- Form Row -->
              <div class="form-row">

                <!-- Form Group (Username) -->
                <div class="form-group col">
                  <label for="username">Username <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="This is your username on the site, not necessarily in a game."></i></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control input-color" id="username" name="username" placeholder="Your username" value="<?php if (isset($_POST['username'])) echo verifyInput($_POST['username']); ?>" required>
                  </div>
                  <span class="text-danger"><?php if (isset($_SESSION['errors']['username'])) echo $_SESSION['errors']['username']; ?></span>
                </div>
                <!-- Form Group (Username) -->

                <!-- Form Group (Gender) -->
                <div class="form-group col">
                  <label for="gender">Gender <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="Your gender in real life"></i></label>
                  <div class="input-group">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                      <label class="btn btn-secondary btn-gender btn-male">
                        <input type="radio" name="gender" id="male" autocomplete="off" value="Male"><i class="fas fa-male"></i> Male
                      </label>
                      <label class="btn btn-secondary btn-gender btn-female">
                        <input type="radio" name="gender" id="female" autocomplete="off" value="Female"><i class="fas fa-female"></i> Female
                      </label>
                      <label class="btn btn-secondary btn-gender btn-gender-anonymous active">
                        <input type="radio" name="gender" id="notSpecified" autocomplete="off" value="Not specified" checked><i class="fas fa-user-secret"></i> Not specified
                      </label>
                    </div>
                  </div>
                  <span class="text-danger"><?php if (isset($_SESSION['errors']['gender'])) echo $_SESSION['errors']['gender']; ?></span>
                </div>
                <!-- Form Group (Gender) -->

              </div>
              <!-- Form Row -->

              <!-- Form Row -->
              <div class="form-row">

                <!-- Form Group (Language) -->
                <div class="form-group col">
                  <label for="language">Language <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="The language in which you speak mainly."></i></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-language"></i></span>
                    </div>
                    <select class="form-control browser-default input-color" id="language" name="language" required>
                      <?php include "$_SERVER[DOCUMENT_ROOT]/core/list/language-list.php"; ?>
                    </select>
                  </div>
                  <span class="text-danger"><?php if (isset($_SESSION['errors']['language'])) echo $_SESSION['errors']['language']; ?></span>
                </div>
                <!-- Form Group (Language) -->

                <!-- Form Group (Country) -->
                <div class="form-group col">
                  <label for="country">Country <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="The country in which you live mainly."></i></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-globe"></i></span>
                    </div>
                    <select class="form-control browser-default input-color" id="country" name="country">
                      <?php include "$_SERVER[DOCUMENT_ROOT]/core/list/country-list.php"; ?>
                    </select>
                  </div>
                  <span class="text-danger"><?php if (isset($_SESSION['errors']['country'])) echo $_SESSION['errors']['country']; ?></span>
                </div>
                <!-- Form Group (Country) -->

              </div>
              <!-- Form Row -->

              <!-- Row Content -->
              <div class="row">

                <!-- Col Content -->
                <div class="col">
                  <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" value="checked" id="tos" name="tos" required>
                    <label class="custom-control-label small" for="tos">
                      By creating an account, you agree to the <?php echo $site_name; ?> <a href="/terms-of-service" target="_blank">Terms of Services</a> and <a href="/privacy-policy" target="_blank">Privacy Policy</a>
                    </label>
                  </div>
                  <span class="text-danger"><?php if (isset($_SESSION['errors']['tos'])) echo $_SESSION['errors']['tos']; ?></span>
                </div>
                <!-- Col Content -->

              </div>
              <!-- Row Content -->

              <!-- Row Content -->
              <div class="row mt-3 justify-content-center">

                <!-- Col Content -->
                <div class="col-6">
                  <button type="submit" class="btn btn-primary btn-block" name="register" aria-describedby="loginHelp">Register</button>

                  <small id="loginHelp" class="form-text text-center">
                    <a href="/login">Already an account ? Click here.</a>
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
