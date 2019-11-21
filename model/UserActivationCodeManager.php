<?php

require_once('core/database/DatabaseManager.php');

class UserActivationCodeManager extends DatabaseManager
{
  public function deleteUserActivationCode($user_id)
  {
    $db = $this->dbConnect();

    $query = $db->prepare("DELETE FROM user_activation_code WHERE user_id=:user_id");
    $query->bindParam(':user_id', $user_id);
    $query->execute();
  }

  public function countUserActivationCode($activation_code)
  {
    $db = $this->dbConnect();

    $query = $db->prepare('SELECT COUNT(activation_code) FROM user_activation_code WHERE activation_code=:activation_code');
    $query->bindParam(':activation_code', $activation_code);
    $query->execute();
    $count = $query->fetch();

    return $count;
  }

  // Getter
  public function getUserActivationCode($user_id)
  {
    $db = $this->dbConnect();

    $query = $db->prepare('SELECT * FROM user_activation_code WHERE user_id=:user_id');
    $query->bindParam(':user_id', $user_id);
    $query->execute();
    $user_activation_code = $query->fetch();

    return $user_activation_code;
  }

  // Setter
  public function setUserActivationCode($user_id, $activation_code)
  {
    $db = $this->dbConnect();

    $query = $db->prepare('INSERT INTO user_activation_code (user_id, activation_code) VALUES (:user_id, :activation_code)');
    $query->bindParam(':user_id', $user_id);
    $query->bindParam(':activation_code', $activation_code);
    $query->execute();
  }
}
