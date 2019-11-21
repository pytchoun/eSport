<?php

require_once('core/database/DatabaseManager.php');
require_once('model/UserRoleManager.php');
require_once('model/EmailManager.php');

class UserManager extends DatabaseManager
{
  public function getUser(int $userId)
  {
    $query = $this->getDb()->prepare('SELECT * FROM user WHERE user_id=:user_id');
    $query->bindParam(':user_id', $userId);
    $query->execute();
    $user = $query->fetch();
    if (!$user) {
      return null;
    }

    return new User($user['user_id'], $user['user_username'], $user['user_email'], $user['user_first_name'],
    $user['user_last_name'], $user['user_language'], $user['user_country'], $user['user_birth_date'],
    $user['user_gender'], $user['user_creation_date'], $user['user_presentation'], $user['user_facebook'],
    $user['user_twitter'], $user['user_twitch'], $user['user_youtube'], $user['user_is_active'], $user['user_is_banned']);
  }

  public function registerUser(string $email, string $password, string $username, string $language, string $country, string $gender): void
  {
    // Register the new user account
    $query = $this->getDb()->prepare('INSERT INTO user (user_email, user_password, user_username, user_language, user_country, user_gender) VALUES (:user_email, :user_password, :user_username, :user_language, :user_country, :user_gender)');
    $query->bindParam(':user_email', $email);
    $query->bindParam(':user_password', $password);
    $query->bindParam(':user_username', $username);
    $query->bindParam(':user_language', $language);
    $query->bindParam(':user_country', $country);
    $query->bindParam(':user_gender', $gender);
    // Hash password
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query->execute();
    // Save user id
    $this_user_id = $this->getDb()->lastInsertId();
    // Insert user role
    $role_id = 1;
    $this->setUserRole($this_user_id, $role_id);
    // Create emailManager
    $emailManager = new EmailManager();
    $emailManager->sendRegisterMail($email, $this_user_id);
  }

  public function generateUserToken(int $user_id, int $length = 20)
  {
    // Generate token
  	$token = bin2hex(random_bytes($length));

    $query = $this->getDb()->prepare('INSERT INTO user_token (user_token, user_id) VALUES (:user_token, :user_id)');
    $query->bindParam(':user_token', $token);
    $query->bindParam(':user_id', $user_id);
    $query->execute();

    return $token;
  }

  public function setUserRole(int $userId, int $roleId): void
  {
    $query = $this->getDb()->prepare('INSERT INTO user_role (role_id, user_id) VALUES (:role_id, :user_id)');
    $query->bindParam(':role_id', $roleId);
    $query->bindParam(':user_id', $userId);
    $query->execute();
  }

  public function deleteUser(int $userId): void
  {
    $query = $this->getDb()->prepare('DELETE FROM user WHERE user_id=:user_id');
    $query->bindParam(':user_id', $userId);
    $query->execute();
  }

  public function saveUser(User $user): void
  {
    $query = $this->getDb()->prepare('UPDATE user SET user_password=:user_password, user_email=:user_email, WHERE user_id=:user_id');
    $query->bindParam(':user_id', $user->getId());
    $query->bindParam(':user_email', $user->getEmail());
    $query->execute();

    $this->saveUserPassword($user, $password);
  }

  public function saveUserPassword(User $user, string $password): void
  {
    // Hash password
    $password = password_hash($password, PASSWORD_DEFAULT);
    // Store it
    $query = $this->getDb()->prepare('UPDATE user SET user_password=:user_password WHERE user_id=:user_id');
    $query->bindParam(':user_id', $user->getId());
    $query->bindParam(':user_password', $password);
    $query->execute();
  }

  public function verifyUserPassword(User $user, string $password): bool
  {
    // hash pw, compare hash with database, return true if ok, false if not ok
    if (password_verify($password, $user['password'])) {
      return true;
    }
    else {
      return false;
    }
  }

  public function userIsConnected(): bool
  {
    if (isset($_SESSION['account']['user_username']) && !empty($_SESSION['account']['user_username']) && isset($_SESSION['account']['user_id']) && !empty($_SESSION['account']['user_id'])) {
      // Check if we have an user with this user session account data
      $user_is_active = 1;
  		$query = $this->getDb()->prepare('SELECT user_email FROM user WHERE user_username=:user_username AND user_id=:user_id AND user_is_active=:user_is_active');
      $query->bindParam(':user_id', $_SESSION['account']['user_id']);
      $query->bindParam(':user_username', $_SESSION['account']['user_username']);
      $query->bindParam(':user_is_active', $user_is_active);
      $query->execute();
      $user = $query->fetch();

      // If we have an user
      if ($user) {
        return true;
      } else {
        // Unset account session
        unset($_SESSION['account']);
  			return false;
  		}
  	} elseif (isset($_COOKIE['user_token']) && isset($_COOKIE['user_id']) && !empty($_COOKIE['user_token']) && !empty($_COOKIE['user_id'])) {
      // Check if we have an user with this user cookie account data
  		$query = $this->getDb()->prepare('SELECT * FROM user_token WHERE user_token=:user_token AND user_id=:user_id');
      $query->bindParam(':user_id', $_COOKIE['user_id']);
      $query->bindParam(':user_token', $_COOKIE['user_token']);
      $query->execute();
      $user = $query->fetch();

      // If we have an user
      if ($user) {
        // Collect account data
        $user_is_active = 1;
        $query = $this->getDb()->prepare('SELECT * FROM user WHERE user_id=:user_id AND user_is_active=:user_is_active');
        $query->bindParam(':user_id', $user['user_id']);
        $query->bindParam(':user_is_active', $user_is_active);
        $query->execute();
        $user = $query->fetch();

        // If we have an user
        if ($user) {
          // Put user id, user email, user username data in session account
          $_SESSION['account']['user_id'] = $user['user_id'];
          $_SESSION['account']['user_email'] = $user['user_email'];
          $_SESSION['account']['user_username'] = $user['user_username'];
          return true;
        } else {
          // Destroy account cookie
          setcookie('user_token', '', time() - 3600);
          setcookie('user_id', '', time() - 3600);
    			return false;
    		}
      } else {
        // Destroy account cookie
        setcookie('user_token', '', time() - 3600);
        setcookie('user_id', '', time() - 3600);
  			return false;
  		}
    }
    return false;
  }

  public function userIsAdmin(): bool
  {
    if (isset($_SESSION['account']['user_username']) && !empty($_SESSION['account']['user_username']) && isset($_SESSION['account']['user_id']) && !empty($_SESSION['account']['user_id'])) {
      if (userIsConnected()) {
        $userRoleManager = new UserRoleManager();

        // Select roles of the user
        $user_roles = $userRoleManager->getUserRoles($_SESSION['account']['user_id']);

        // Check if the user have an admin role
        foreach ($user_roles as $user_role) {
          $role_name = $userRoleManager->getRole($user_role['role_id']);

          if ($role_name['role_name'] === "Admin") {
            return true;
          }
        }
        return false;
      }
      return false;
    }
    return false;
  }

  // Check email input
  public function checkEmailInput($email)
  {
    $error = false;

    if (empty($email)) {
      $_SESSION['errors']['email'] = "An email is required";
      $error = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $_SESSION['errors']['email'] = "Invalid email format";
      $error = true;
    } elseif (mb_strlen($email) > 255) {
      $_SESSION['errors']['email'] = "Your email must be less than 255 characters long";
      $error = true;
    } else {
      // Check that the email isn't already used
      $query = $this->getDb()->prepare('SELECT COUNT(user_email) FROM user WHERE user_email=:user_email');
      $query->bindParam(':user_email', $email);
      $query->execute();
      $count = $query->fetch();

      if ($count[0] != 0) {
        $_SESSION['errors']['email'] = "Email is already in use";
        $error = true;
      }
    }

    return $error;
  }

  // Check confirm email input
  public function checkConfirmEmailInput($confirm_email, $email)
  {
    $error = false;

    if (empty($confirm_email)) {
      $_SESSION['errors']['confirm_email'] = "You must confirm your email";
      $error = true;
    } elseif ($confirm_email !== $email) {
      $_SESSION['errors']['confirm_email'] = "Emails do not match";
      $error = true;
    }

    return $error;
  }

  // Check password input
  public function checkPasswordInput($password)
  {
    $error = false;

    if (empty($password)) {
      $_SESSION['errors']['password'] = "A password is required";
      $error = true;
    } elseif(mb_strlen($password) < 8 || mb_strlen($password) > 72) {
      $_SESSION['errors']['password'] = "Your password must be between 8 and 72 characters long";
      $error = true;
    }

    return $error;
  }

  // Check confirm password input
  public function checkConfirmPasswordInput($confirm_password, $password)
  {
    $error = false;

    if (empty($confirm_password)) {
      $_SESSION['errors']['confirm_password'] = "You must confirm your password";
      $error = true;
    } elseif ($confirm_password !== $confirm_password) {
      $_SESSION['errors']['confirm_password'] = "Passwords do not match";
      $error = true;
    }

    return $error;
  }

  // Check username input
  public function checkUsernameInput($username)
  {
    $error = false;

    if (empty($username)) {
      $_SESSION['errors']['username'] = "An username is required";
      $error = true;
    } elseif (!ctype_alnum(trim(str_replace(' ', '', $username)))) {
      $_SESSION['errors']['username'] = "Only letters and numbers are allowed";
      $error = true;
    } elseif (mb_strlen($username) > 50) {
      $_SESSION['errors']['username'] = "Your username must be between 1 and 50 characters long";
      $error = true;
    } else {
      // Check that the username isn't already used
      $query = $this->getDb()->prepare('SELECT COUNT(user_username) FROM user WHERE user_username=:user_username');
      $query->bindParam(':user_username', $username);
      $query->execute();
      $count = $query->fetch();

      if ($count[0] != 0) {
        $_SESSION['errors']['username'] = "Username is already in use";
        $error = true;
      }
    }

    return $error;
  }

  // Check language select
  public function checkLanguageSelect($language)
  {
    $error = false;

    if (empty($language)) {
      $_SESSION['errors']['language'] = "A language is required";
      $error = true;
    } elseif (languageArray($language) == false) {
      $_SESSION['errors']['language'] = "This language is invalid";
      $error = true;
    }

    return $error;
  }

  // Check country select
  public function checkCountrySelect($country)
  {
    $error = false;

    if (empty($country)) {
      $_SESSION['errors']['country'] = "A country is required";
      $error = true;
    } elseif (countryArray($country) == false) {
      $_SESSION['errors']['country'] = "This country is invalid";
      $error = true;
    }

    return $error;
  }

  // Check gender select
  public function checkGenderSelect($gender)
  {
    $error = false;

    if (empty($gender)) {
      $_SESSION['errors']['gender'] = "A gender is required";
      $error = true;
    } elseif (genderArray($gender) == false) {
      $_SESSION['errors']['gender'] = "This gender is invalid";
      $error = true;
    }

    return $error;
  }

  public function getUserIfResetCodeValid($reset_code)
  {
    // Select the user with this reset code and check code date
    $user_query = $this->getDb()->prepare('SELECT * FROM user_reset_password WHERE reset_code=:reset_code AND code_date >= DATE_SUB(NOW(), INTERVAL 1 HOUR)');
    $user_query->bindParam(':reset_code', $reset_code);
    $user_query->execute();
    $user = $user_query->fetch();

    return $user;
  }














  // // Getter
  // public function getUser($user_id)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('SELECT * FROM user WHERE user_id=:user_id');
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  //   $user = $query->fetch();
  //
  //   return $user;
  // }
  //
  // public function getUserUsername($user_id)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('SELECT user_username FROM user WHERE user_id=:user_id');
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  //   $user = $query->fetch();
  //
  //   return $user;
  // }
  //
  // public function getUserEmail($user_id)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('SELECT user_email FROM user WHERE user_id=:user_id');
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  //   $user = $query->fetch();
  //
  //   return $user;
  // }
  //
  // public function getUserPassword($user_id)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('SELECT user_password FROM user WHERE user_id=:user_id');
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  //   $user = $query->fetch();
  //
  //   return $user;
  // }
  //
  // public function getUserFirstName($user_id)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('SELECT user_first_name FROM user WHERE user_id=:user_id');
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  //   $user = $query->fetch();
  //
  //   return $user;
  // }
  //
  // public function getUserLastName($user_id)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('SELECT user_last_name FROM user WHERE user_id=:user_id');
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  //   $user = $query->fetch();
  //
  //   return $user;
  // }
  //
  // public function getUserLanguage($user_id)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('SELECT user_language FROM user WHERE user_id=:user_id');
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  //   $user = $query->fetch();
  //
  //   return $user;
  // }
  //
  // public function getUserCountry($user_id)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('SELECT user_country FROM user WHERE user_id=:user_id');
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  //   $user = $query->fetch();
  //
  //   return $user;
  // }
  //
  // public function getUserBirthDate($user_id)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('SELECT user_birth_date FROM user WHERE user_id=:user_id');
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  //   $user = $query->fetch();
  //
  //   return $user;
  // }
  //
  // public function getUserGender($user_id)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('SELECT user_gender FROM user WHERE user_id=:user_id');
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  //   $user = $query->fetch();
  //
  //   return $user;
  // }
  //
  // public function getUserCreationDate($user_id)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('SELECT user_creation_date FROM user WHERE user_id=:user_id');
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  //   $user = $query->fetch();
  //
  //   return $user;
  // }
  //
  // public function getUserPresentation($user_id)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('SELECT user_presentation FROM user WHERE user_id=:user_id');
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  //   $user = $query->fetch();
  //
  //   return $user;
  // }
  //
  // public function getUserFacebook($user_id)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('SELECT user_facebook FROM user WHERE user_id=:user_id');
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  //   $user = $query->fetch();
  //
  //   return $user;
  // }
  //
  // public function getUserTwitter($user_id)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('SELECT user_twitter FROM user WHERE user_id=:user_id');
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  //   $user = $query->fetch();
  //
  //   return $user;
  // }
  //
  // public function getUserTwitch($user_id)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('SELECT user_twitch FROM user WHERE user_id=:user_id');
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  //   $user = $query->fetch();
  //
  //   return $user;
  // }
  //
  // public function getUserYoutube($user_id)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('SELECT user_youtube FROM user WHERE user_id=:user_id');
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  //   $user = $query->fetch();
  //
  //   return $user;
  // }
  //
  // public function getUserIsActive($user_id)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('SELECT user_is_active FROM user WHERE user_id=:user_id');
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  //   $user = $query->fetch();
  //
  //   return $user;
  // }
  //
  // public function getUserIsBanned($user_id)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('SELECT user_is_banned FROM user WHERE user_id=:user_id');
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  //   $user = $query->fetch();
  //
  //   return $user;
  // }
  //
  // // Setter
  // public function setUserEmail($user_id, $user_email)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('UPDATE user SET user_email=:user_email WHERE user_id=:user_id');
  //   $query->bindParam(':user_email', $user_email);
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  // }
  //
  // public function setUserPassword($user_id, $user_password)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('UPDATE user SET user_password=:user_password WHERE user_id=:user_id');
  //   $query->bindParam(':user_password', $user_password);
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  // }
  //
  // public function setUserFirstName($user_id, $user_first_name)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('UPDATE user SET user_first_name=:user_first_name WHERE user_id=:user_id');
  //   $query->bindParam(':user_first_name', $user_first_name);
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  // }
  //
  // public function setUserLastName($user_id, $user_last_name)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('UPDATE user SET user_last_name=:user_last_name WHERE user_id=:user_id');
  //   $query->bindParam(':user_last_name', $user_last_name);
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  // }
  //
  // public function setUserLanguage($user_id, $user_language)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('UPDATE user SET user_language=:user_language WHERE user_id=:user_id');
  //   $query->bindParam(':user_language', $user_language);
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  // }
  //
  // public function setUserCountry($user_id, $user_country)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('UPDATE user SET user_country=:user_country WHERE user_id=:user_id');
  //   $query->bindParam(':user_country', $user_country);
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  // }
  //
  // public function setUserBirthDate($user_id, $user_birth_date)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('UPDATE user SET user_birth_date=:user_birth_date WHERE user_id=:user_id');
  //   $query->bindParam(':user_birth_date', $user_birth_date);
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  // }
  //
  // public function setUserGender($user_id, $user_gender)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('UPDATE user SET user_gender=:user_gender WHERE user_id=:user_id');
  //   $query->bindParam(':user_gender', $user_gender);
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  // }
  //
  // public function setUserPresentation($user_id, $user_presentation)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('UPDATE user SET user_presentation=:user_presentation WHERE user_id=:user_id');
  //   $query->bindParam(':user_presentation', $user_presentation);
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  // }
  //
  // public function setUserFacebook($user_id, $user_facebook)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('UPDATE user SET user_facebook=:user_facebook WHERE user_id=:user_id');
  //   $query->bindParam(':user_facebook', $user_facebook);
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  // }
  //
  // public function setUserTwitter($user_id, $user_twitter)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('UPDATE user SET user_twitter=:user_twitter WHERE user_id=:user_id');
  //   $query->bindParam(':user_twitter', $user_twitter);
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  // }
  //
  // public function setUserTwitch($user_id, $user_twitch)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('UPDATE user SET user_twitch=:user_twitch WHERE user_id=:user_id');
  //   $query->bindParam(':user_twitch', $user_twitch);
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  // }
  //
  // public function setUserYoutube($user_id, $user_youtube)
  // {
  //   $db = $this->dbConnect();
  //
  //   $query = $db->prepare('UPDATE user SET user_youtube=:user_youtube WHERE user_id=:user_id');
  //   $query->bindParam(':user_youtube', $user_youtube);
  //   $query->bindParam(':user_id', $user_id);
  //   $query->execute();
  // }
}
