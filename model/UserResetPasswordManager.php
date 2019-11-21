<?php

require_once('core/database/DatabaseManager.php');

class UserResetPasswordManager extends DatabaseManager
{
  public function deleteUserResetPassword($user_id)
  {
    $db = $this->dbConnect();

    $query = $db->prepare("DELETE FROM user_reset_password WHERE user_id=:user_id");
    $query->bindParam(':user_id', $user_id);
    $query->execute();
  }

  public function countUserResetPassword($reset_code)
  {
    $db = $this->dbConnect();

    $query = $db->prepare('SELECT COUNT(reset_code) FROM user_reset_password WHERE reset_code=:reset_code');
    $query->bindParam(':reset_code', $reset_code);
    $query->execute();
    $count = $query->fetch();

    return $count;
  }

  // Getter
  public function getUserResetPassword($user_id)
  {
    $db = $this->dbConnect();

    $query = $db->prepare('SELECT * FROM user_reset_password WHERE user_id=:user_id');
    $query->bindParam(':user_id', $user_id);
    $query->execute();
    $user_reset_password = $query->fetchAll();

    return $user_reset_password;
  }

  // Setter
  public function setUserResetPassword($user_id, $reset_code)
  {
    $db = $this->dbConnect();

    $query = $db->prepare('INSERT INTO user_reset_password (user_id, reset_code) VALUES (:user_id, :reset_code)');
    $query->bindParam(':user_id', $user_id);
    $query->bindParam(':reset_code', $reset_code);
    $query->execute();
  }
}
