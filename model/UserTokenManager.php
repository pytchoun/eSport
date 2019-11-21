<?php

require_once('core/database/DatabaseManager.php');

class UserTokenManager extends DatabaseManager
{
  // Getter
  public function getUserToken($user_id)
  {
    $db = $this->dbConnect();

    $query = $db->prepare('SELECT * FROM user_token WHERE user_id=:user_id');
    $query->bindParam(':user_id', $user_id);
    $query->execute();
    $user_token = $query->fetchAll();

    return $user_token;
  }
}
