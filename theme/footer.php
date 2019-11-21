<!-- Footer Content -->
<footer class="mt-auto">
  <div class="container-fluid">

    <!-- Additional Link -->
    <div class="row py-3 justify-content-center">
      <div class="col-auto">
        <p class="mb-0">
          <a href="/about-us">About us</a>
        </p>
      </div>

      <div class="col-auto">
        <p class="mb-0">
          <a href="/contact" class="ml-3">Contact</a>
        </p>
      </div>

      <div class="col-auto">
        <p class="mb-0">
          <a href="/terms-of-service" class="ml-3">Terms of Service</a>
        </p>
      </div>

      <div class="col-auto">
        <p class="mb-0">
          <a href="/privacy-policy" class="ml-3">Privacy Policy</a>
        </p>
      </div>

      <div class="col-auto">
        <p class="mb-0">
          <a href="/cookie-policy" class="ml-3">Cookie Policy</a>
        </p>
      </div>
    </div>
    <!-- Additional Link -->

    <!-- Copyright -->
    <div class="row border-top footer-border py-3">
      <div class="col">
        <p class="text-muted text-center mb-0">
          Copyright © <?php echo $year ?> Paladins Challenge. All rights reserved. Paladins is a registered trademark of Hi-Rez Studios.
        </p>
      </div>
    </div>
    <!-- Copyright -->

  </div>
</footer>
<!-- Footer Content -->

</div>
<!-- Page Content  -->
</div>
<!-- Wrapper -->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script type="text/javascript">
// Fixe issue with Bootstrap toast
toastr.options.toastClass = 'toastr';

// Custom toastr
toastr.options.progressBar = true;
toastr.options.showMethod = 'slideDown';
toastr.options.hideMethod = 'slideUp';
toastr.options.closeMethod = 'slideUp';
</script>

<?php
// Toastr management
require "$_SERVER[DOCUMENT_ROOT]/core/functions/php/toastr.php";

// Unset isset session
if(isset($_SESSION['errors']))
{
  unset($_SESSION['errors']);
}
if(isset($_SESSION['login']))
{
  unset($_SESSION['login']);
}
?>

<script type="text/javascript">
// Sidebar Collapse
$(document).ready(function ()
{
  $('#sidebarCollapse').on('click', function ()
  {
    $('#sidebar, #content').toggleClass('collapse');
  });
});

// Enable tooltips everywhere
$(function ()
{
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

</body>
</html>
