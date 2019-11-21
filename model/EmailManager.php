<?php

require_once('core/database/DatabaseManager.php');

class EmailManager extends DatabaseManager
{
  // Send register mail to the new user email account
  public function sendRegisterMail($email, $user_id)
  {
    $site_name = "Paladins Challenge";
    $subject = "Welcome to {$site_name}";

    // Generate an user activation code
    $activation_code = $this->generateUserActivationCode($user_id);

    // Url for account activation
    $href = "https://{$_SERVER['SERVER_NAME']}/account-activation/{$activation_code}";

    ob_start();
    ?>
    <a href="<?php echo $href; ?>">link</a>.
    <?php
    $link = ob_get_contents();

    // Email message
    $message = "
    <html><head></head><body>

    Your account was created. To activate your account, click on the following {$link} <br> <br>

    If the link does not work copy it into your browser. <br>
    {$href} <br> <br>

    The link is valid for 1 hour. <br> <br>

    Regards, <br>
    Support {$site_name} <br><br>
    This is an automatic message, thank you for not answering it.<br>

    </body></html>
    ";

    // To send HTML mail, the Content-type header must be set
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

    // Additional headers
    $headers .= "From: {$site_name} <no-reply@{$site_name}.com>" . "\r\n";

    // Mail it
    mail($email, $subject, $message, $headers);
  }

  // Generate an user activation code
  public function generateUserActivationCode($user_id)
  {
    // Delete old activation code
    $query = $this->getDb()->prepare("DELETE FROM user_activation_code WHERE user_id=:user_id");
    $query->bindParam(':user_id', $user_id);
    $query->execute();

    while (true) {
      // Generate the activation code
      $activation_code = bin2hex(random_bytes(20));

      // Check that the activation code isn't already used
      $query = $this->getDb()->prepare('SELECT COUNT(activation_code) FROM user_activation_code WHERE activation_code=:activation_code');
      $query->bindParam(':activation_code', $activation_code);
      $query->execute();
      $count = $query->fetch();

      if ((int)$count[0] === 0) {
        break;
      }
    }

    // Insert activation code
    $query = $this->getDb()->prepare('INSERT INTO user_activation_code (user_id, activation_code) VALUES (:user_id, :activation_code)');
    $query->bindParam(':user_id', $user_id);
    $query->bindParam(':activation_code', $activation_code);
    $query->execute();

    return $activation_code;
  }

  // Send reset user password mail to the user email
  public function sendResetUserPasswordMail($email, $user_id)
  {
    $site_name = "Paladins Challenge";
    $subject = "Reset your {$site_name} account password";

    // Generate an user reset code
    $reset_code = $this->generateUserResetCode($user_id);

    // Url for reset link
    $href = "https://{$_SERVER['SERVER_NAME']}/account-recovery/{$reset_code}";

    ob_start();
    ?>
    <a href="<?php echo $href; ?>">link</a>.
    <?php
    $link = ob_get_contents();

    // Email message
    $message = "
    <html><head></head><body>

    You have requested the reset of your password. To reset it, click on the following {$link} <br> <br>

    If the link does not work copy it into your browser. <br>
    {$href} <br> <br>

    The link is valid for 1 hour. <br> <br>

    Regards, <br>
    Support {$site_name} <br><br>
    This is an automatic message, thank you for not answering it.<br>

    </body></html>
    ";

    // To send HTML mail, the Content-type header must be set
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

    // Additional headers
    $headers .= "From: {$site_name} <no-reply@{$site_name}.com>" . "\r\n";

    // Mail it
    mail($email, $subject, $message, $headers);
  }

  // Generate an user reset code
  public function generateUserResetCode($user_id)
  {
    // Delete old reset code
    $query = $this->getDb()->prepare("DELETE FROM user_reset_password WHERE user_id=:user_id");
    $query->bindParam(':user_id', $user_id);
    $query->execute();

    while (true) {
      // Generate an user reset code
      $reset_code = bin2hex(random_bytes(20));

      // Check that the reset code isn't already used
      $query = $this->getDb()->prepare('SELECT COUNT(reset_code) FROM user_reset_password WHERE reset_code=:reset_code');
      $query->bindParam(':reset_code', $reset_code);
      $query->execute();
      $count = $query->fetch();

      if ((int)$count[0] === 0) {
        break;
      }
    }

    // Insert reset code
    $query = $this->getDb()->prepare('INSERT INTO user_reset_password (user_id, reset_code) VALUES (:user_id, :reset_code)');
    $query->bindParam(':user_id', $user_id);
    $query->bindParam(':reset_code', $reset_code);
    $query->execute();

    return $reset_code;
  }

  // Send update user password mail to the user email
  public function sendUpdateUserPasswordMail($email)
  {
    $site_name = "Paladins Challenge";
    $subject = "Confirm password change in your {$site_name} account";

    ob_start();
    ?>
    <a href="<?php echo $href; ?>">link</a>.
    <?php
    $link = ob_get_contents();

    // Email message
    $message = "
    <html><head></head><body>

    We inform you that your change of your password is done. <br>
    If you are not at the origin of this request, contact us immediately. <br> <br>

    Regards, <br>
    Support {$site_name} <br><br>
    This is an automatic message, thank you for not answering it.<br>

    </body></html>
    ";

    // To send HTML mail, the Content-type header must be set
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

    // Additional headers
    $headers .= "From: {$site_name} <no-reply@{$site_name}.com>" . "\r\n";

    // Mail it
    mail($email, $subject, $message, $headers);
  }
}
