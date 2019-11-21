<?php
include "$_SERVER[DOCUMENT_ROOT]/theme/head.php";
include "$_SERVER[DOCUMENT_ROOT]/theme/sidebar.php";
include "$_SERVER[DOCUMENT_ROOT]/theme/navbar.php";
?>

<!-- Main -->
<main>

  <!-- Container -->
  <div class="container">

    <!-- Row -->
    <div class="row">

      <!-- Col -->
      <div class="col">

        <?php if ($activation) { ?>

          <!-- Account is activated -->
          <!-- Alert -->
          <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Account is activated</h4>
            <p>
              You can login.
            </p>

            <hr>

            <a href="/login" class="btn btn-primary">Login</a>
          </div>
          <!-- Alert -->
          <!-- Account is activated -->

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
    <!-- Row -->

  </div>
  <!-- Container -->

</main>
<!-- Main -->

<?php include "$_SERVER[DOCUMENT_ROOT]/theme/footer.php"; ?>
