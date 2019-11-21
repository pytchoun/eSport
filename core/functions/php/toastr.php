<!-- <script type="text/javascript">
toastr.error('Action validated.')
toastr.success('Action validated.')
toastr.info('Action validated.')
toastr.warning('Action validated.')
</script> -->

<?php

// Success notification
if (isset($_SESSION['notification']['success'])) { ?>
  <script type="text/javascript">
  toastr.success('Action validated.')
  </script>
<?php }

// Error notification
if (isset($_SESSION['notification']['error'])) { ?>
  <script type="text/javascript">
  toastr.error('An error has occurred.')
  </script>
<?php }

// Successfull registration notification
if (isset($_SESSION['notification']['registration'])) { ?>
  <script type="text/javascript">
  toastr.success('Your account has been created, you have received an email to activate your account.')
  </script>
<?php }

// Account not found notification
if (isset($_SESSION['notification']['login']['error'])) { ?>
  <script type="text/javascript">
  toastr.error('Account not found.')
  </script>
<?php }

// Successfull login notification
elseif (isset($_SESSION['notification']['login'])) { ?>
  <script type="text/javascript">
  toastr.success('Welcome back Champion.')
  </script>
<?php }

// Successfull logout notification
if (isset($_SESSION['notification']['logout'])) { ?>
  <script type="text/javascript">
  toastr.success('Goodbye Champion.')
  </script>
<?php }

// Email sent notification
if (isset($_SESSION['notification']['email'])) { ?>
  <script type="text/javascript">
  toastr.info('An email has been sent.')
  </script>
<?php }

// Unset notification session
if (isset($_SESSION['notification'])) {
  unset($_SESSION['notification']);
}
