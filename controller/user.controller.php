<?php
require_once('model/UserManager.php');
require_once('model/UserRoleManager.php');
require_once('model/UserTokenManager.php');
require_once('model/UserActivationCodeManager.php');
require_once('model/UserResetPasswordManager.php');
require_once('model/EmailManager.php');

function loginView()
{
  require "$_SERVER[DOCUMENT_ROOT]/theme/header.php";

  // SEO informations
  $page_title = "Login - {$site_name}";
  $page_description = "Login to your {$site_name} account.";
  $page_keywords = "{$site_name}, Paladins, Hi-Rez, challenge, login";

  // Create userManager
  $userManager = new UserManager();

  // User is connected redirect him to his profile page
  $userIsConnected = $userManager->userIsConnected();
  if ($userIsConnected) {
    profileRedirection();
  }

  // User press login button
  if (isset($_POST['login'])) {
    if(formIsValid()) {
      // Select the user with the input email
  		$query = $userManager->getDb()->prepare('SELECT * FROM user WHERE user_email=:user_email');
      $query->bindParam(':user_email', $_POST['email']);
  		$query->execute();
  		$user = $query->fetch();

      // If we have an user
      if ($user) {
        // Check if the password input is the same with the password in database
    		if (password_verify($_POST['password'], $user['user_password'])) {

          // Check if account is active
          if ($user['user_is_active'] != 1) {
            $_SESSION['login']['activation'] = 1;
            $_SESSION['login']['user_email'] = $user['user_email'];
            $_SESSION['login']['user_id'] = $user['user_id'];

            // Redirect user to login page
            loginRedirection();
          }

          if (password_needs_rehash($user['user_password'], PASSWORD_DEFAULT)) {
            $newHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Update user password hash in db
            $query = $userManager->getDb()->prepare('UPDATE user SET user_password=:user_password WHERE user_email=:user_email');
            $query->bindParam(':user_password', $newHash);
            $query->bindParam(':user_email', $user['user_email']);
            $query->execute();
          }

          // Put user id, user email, user username data in session account
          $_SESSION['account']['user_id'] = $user['user_id'];
          $_SESSION['account']['user_email'] = $user['user_email'];
          $_SESSION['account']['user_username'] = $user['user_username'];

          // Check if remember me is checked
          if (isset($_POST['remember-me'])) {
            // Generate the user token for re login the user
            $token = $userManager->generateUserToken($user['user_id']);

            // Set cookie for save login for 30 days
            setcookie('user_token', $token, time() + (86400 * 30), '/');
            setcookie('user_id', $_SESSION['account']['user_id'], time() + (86400 * 30), '/');
          }

          // Successfull login notification
          $_SESSION['notification']['login'] = 1;

          // Redirect the user to his profile page
          profileRedirection();
        } else {
          // Account not found notification
          $_SESSION['notification']['login']['error'] = 1;
        }
      } else {
        // Account not found notification
        $_SESSION['notification']['login']['error'] = 1;
      }
    } else {
      // Error notification
      errorNotification();
    }

    // Redirect the user to the login page
    loginRedirection();
  }

  // User ask for an activation email
  if (isset($_POST['resend-email'])) {
    if (formIsValid()) {
      // Select the user with the input email
      $query = $userManager->getDb()->prepare('SELECT * FROM user WHERE user_email=:user_email');
      $query->bindParam(':user_email', $_POST['email']);
      $query->execute();
      $user = $query->fetch();

      if ($user) {
        // Create emailManager
        $emailManager = new EmailManager();
        $emailManager->sendRegisterMail($_POST['email'], $_POST['user-id']);
      }

      $_SESSION['notification']['email'] = 1;
    } else {
      // Error notification
      errorNotification();
    }

    loginRedirection();
  }

  require "$_SERVER[DOCUMENT_ROOT]/view/user/login.view.php";
}

function registerView()
{
  require "$_SERVER[DOCUMENT_ROOT]/theme/header.php";

  // SEO informations
  $page_title = "Register - {$site_name}";
  $page_description = "Register on {$site_name}.";
  $page_keywords = "{$site_name}, Paladins, Hi-Rez, challenge, register";

  // Create userManager
  $userManager = new UserManager();

  // User is connected redirect him to his profile page
  $userIsConnected = $userManager->userIsConnected();
  if ($userIsConnected) {
    profileRedirection();
  }

  // User press register button
  if (isset($_POST['register'])) {
    if(formIsValid()) {
      // Check email input
      $email = verifyInput($_POST['email']);
      $email_error = $userManager->checkEmailInput($email);

      // Check confirm email input
      $confirm_email = verifyInput($_POST['confirm-email']);
      $confirm_email_error = $userManager->checkConfirmEmailInput($confirm_email, $email);

      // Check password input
      $password = verifyInput($_POST['password']);
      $password_error = $userManager->checkPasswordInput($password);

      // Check confirm password input
      $confirm_password = verifyInput($_POST['confirm-password']);
      $confirm_password_error = $userManager->checkConfirmPasswordInput($confirm_password, $password);

      // Check username input
      $username = verifyInput($_POST['username']);
      $username_error = $userManager->checkUsernameInput($username);

      // Check language select
      $language_error = $userManager->checkLanguageSelect($_POST['language']);

      // Check country select
      $country_error = $userManager->checkCountrySelect($_POST['country']);

      // Check gender select
      $gender_error = $userManager->checkGenderSelect($_POST['gender']);

      // Check ToS check
      if (!isset($_POST['tos'])) {
        $_SESSION['errors']['tos'] = "You must validate the Terms of Services and Privacy Policy";
        $tos_error = true;
      } else {
        $tos_error = false;
      }

      if (!$email_error && !$confirm_email_error && !$password_error && !$confirm_password_error && !$username_error && !$language_error && !$country_error && !$gender_error && !$tos_error) {
        // Register the new user account + Send register mail to the new user account
        $userManager->registerUser($email, $password, $username, $_POST['language'], $_POST['country'], $_POST['gender']);

        // Successfull registration notification
        $_SESSION['notification']['registration'] = 1;

        // Redirect the user to the login page
        loginRedirection();
      } else {
        // Error notification
        errorNotification();
      }
    } else {
      // Error notification
      errorNotification();
    }

    // Redirect the user to the register page
    registerRedirection();
  }

  require "$_SERVER[DOCUMENT_ROOT]/view/user/register.view.php";
}

function logoutView()
{
  require "$_SERVER[DOCUMENT_ROOT]/theme/header.php";
  
  // Create userManager
  $userManager = new UserManager();

  // User is not connected redirect him to the home page
  $userIsConnected = $userManager->userIsConnected();
  if (!$userIsConnected) {
    homeRedirection();
  }

  // Website user logout
  // Clean the session account
  unset($_SESSION['account']);

  // Clean cookie for re login the user
  if (isset($_COOKIE['user_token']) && isset($_COOKIE['user_id'])) {
    // Remove user token from db
    $query = $userManager->getDb()->prepare("DELETE FROM user_token WHERE user_token=:user_token AND user_id=:user_id");
    $query->bindParam(':user_token', $_COOKIE['user_token']);
    $query->bindParam(':user_id', $_COOKIE['user_id']);
    $query->execute();

    // Destroy cookie
    setcookie('user_token', '', time() - 3600);
    setcookie('user_id', '', time() - 3600);
  }

  // Successfull logout notification
  $_SESSION['notification']['logout'] = 1;

  // Redirect the user to the home page
  homeRedirection();
}

function accountActivationView($url)
{
  require "$_SERVER[DOCUMENT_ROOT]/theme/header.php";

  // SEO informations
  $page_title = "Account activation - {$site_name}";
  $page_description = "Activate your {$site_name} account.";
  $page_keywords = "{$site_name}, Paladins, Hi-Rez, challenge, Account activation";

  // Create userManager
  $userManager = new UserManager();

  // User is connected redirect him to his profile page
  $userIsConnected = $userManager->userIsConnected();
  if ($userIsConnected) {
    profileRedirection();
  }

  // Check get param
  if (isset($url[1])) {
    // Secure the get param
    $activation_code = htmlspecialchars($url[1], ENT_QUOTES);

    if ($activation_code) {
      // Select the user with this activation code and check code date
      $query = $userManager->getDb()->prepare('SELECT * FROM user_activation_code WHERE activation_code=:activation_code AND code_date >= DATE_SUB(NOW(), INTERVAL 1 HOUR)');
      $query->bindParam(':activation_code', $activation_code);
      $query->execute();
      $user = $query->fetch();

      if ($user) {
        // Activate user account
        $query = $userManager->getDb()->prepare('UPDATE user SET user_is_active=1 WHERE user_id=:user_id');
        $query->bindParam(':user_id', $user['user_id']);
        $query->execute();

        // Delete the activation code
        $query = $userManager->getDb()->prepare("DELETE FROM user_activation_code WHERE activation_code=:activation_code");
        $query->bindParam(':activation_code', $activation_code);
        $query->execute();

        $activation = true;
      } else {
        $activation = false;
      }
    } else {
      // Redirect user to error 404
      require "$_SERVER[DOCUMENT_ROOT]/view/page/error404.view.php";
      return;
    }
  } else {
    // Redirect user to error 404
    require "$_SERVER[DOCUMENT_ROOT]/view/page/error404.view.php";
    return;
  }

  require "$_SERVER[DOCUMENT_ROOT]/view/user/accountActivation.view.php";
}

function accountRecoveryView($url)
{
  require "$_SERVER[DOCUMENT_ROOT]/theme/header.php";

  // SEO informations
  $page_title = "Account recovery - {$site_name}";
  $page_description = "Recover your {$site_name} account.";
  $page_keywords = "{$site_name}, Paladins, Hi-Rez, challenge, account recovery";

  // Create userManager
  $userManager = new UserManager();

  // User is connected redirect him to his profile page
  $userIsConnected = $userManager->userIsConnected();
  if ($userIsConnected) {
    profileRedirection();
  }

  // Check get param
  if (isset($url[1])) {
    // Secure the get param
    $reset_code = htmlspecialchars($url[1], ENT_QUOTES);

    // This will be empty if the reset code is not valid
    $user = $userManager->getUserIfResetCodeValid($reset_code);

    // Check coupon
    $coupon = false;
    if ($user) {
      $coupon = true;
    }
  } else {
    // Redirect user to error 404
    require "$_SERVER[DOCUMENT_ROOT]/view/page/error404.view.php";
    return;
  }

  // User press the reset password button
  if (isset($_POST['confirm-password'])) {
    // Check if the user was returned earlier, if so we can reset the user's password
    if (!empty($user)) {
      if (formIsValid()) {
        // Verify password input
        $password = verifyInput($_POST['new-password']);
        $confirm_password = verifyInput($_POST['confirm-new-password']);

        // If confirm password is empty, set session variable for notifying the user and return
        if (empty($confirm_password)) {
          $_SESSION['errors']['confirm_new_password'] = "You must confirm your password";

          // Or redirect to display errors ?
          return;
        }

        // If passwords match
        $passwords_match = false;
        if ($password == $confirm_password) {
          $passwords_match = true;
        } else {
          $_SESSION['errors']['confirm_new_password'] = "Passwords do not match";
        }

        if ($passwords_match == true) {
          if (mb_strlen($password) < 8 || mb_strlen($password) > 72) {
            // If password does not meet requirements, set a session variable for notifying the user
            $_SESSION['errors']['new_password'] = "Your password must be between 8 and 72 characters long";
          } else {
            // Update user password
            $new_password_hashed = password_hash($password, PASSWORD_DEFAULT);

            $update_password_query = $userManager->getDb()->prepare('UPDATE user SET user_password=:user_password WHERE user_id=:user_id');
            $update_password_query->bindParam(':user_id', $user['user_id']);
            $update_password_query->bindParam(':user_password', $new_password_hashed);
            $update_password_query->execute();

            // Delete reset password code
            $delete_reset_code_query = $userManager->getDb()->prepare("DELETE FROM user_reset_password WHERE user_id=:user_id AND reset_code=:reset_code");
            $delete_reset_code_query->bindParam(':user_id', $user['user_id']);
            $delete_reset_code_query->bindParam(':reset_code', $user['reset_code']);
            $delete_reset_code_query->execute();

            // Select the user with this user id
            $query = $userManager->getDb()->prepare('SELECT user_email FROM user WHERE user_id=:user_id');
            $query->bindParam(':user_id', $user['user_id']);
            $query->execute();
            $user = $query->fetch();

            // Send update user password mail to the user email
            // Create emailManager
            $emailManager = new EmailManager();
            $emailManager->sendUpdateUserPasswordMail($user['user_email']);

            // Display a success reset password
            $_SESSION['resetPassword']['success'] = 1;

            loginRedirection();
          }
        }
      } else {
        // Error notification
        errorNotification();
      }
    } else {
      // If the user is empty maybe show an error here or do nothing
      // Error notification
      errorNotification();
    }
  }

  require "$_SERVER[DOCUMENT_ROOT]/view/user/accountRecovery.view.php";
}

function accountResetPasswordView()
{
  require "$_SERVER[DOCUMENT_ROOT]/theme/header.php";

  // SEO informations
  $page_title = "Reset password - {$site_name}";
  $page_description = "Reset your password on {$site_name}.";
  $page_keywords = "{$site_name}, Paladins, Hi-Rez, challenge, reset password";

  // Create userManager
  $userManager = new UserManager();

  // User is connected redirect him to his profile page
  $userIsConnected = $userManager->userIsConnected();
  if ($userIsConnected) {
    profileRedirection();
  }

  // User press reset password button
  if (isset($_POST['reset-password'])) {
    if (formIsValid()) {
      // Select the user with the input email
  		$query = $userManager->getDb()->prepare('SELECT * FROM user WHERE user_email=:user_email');
      $query->bindParam(':user_email', $_POST['email']);
  		$query->execute();
  		$user = $query->fetch();

      if ($user) {
        // Send reset user password mail to the user email
        // Create emailManager
        $emailManager = new EmailManager();
        $emailManager->sendResetUserPasswordMail($user['user_email'], $user['user_id']);

        // Email sent notification
        $_SESSION['notification']['email'] = 1;
      } else {
        // Account not found notification
        $_SESSION['notification']['login']['error'] = 1;
      }
    } else {
      // Error notification
      errorNotification();
    }

    resetPasswordRedirection();
  }

  require "$_SERVER[DOCUMENT_ROOT]/view/user/accountResetPassword.view.php";
}
