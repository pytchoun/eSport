<?php

require_once('core/database/DatabaseManager.php');

class UserRoleManager extends DatabaseManager
{
  // Getter
  public function getUserRoles($userId)
  {
    $query = $this->getDb()->prepare('SELECT * FROM user_role WHERE user_id=:user_id');
    $query->bindParam(':user_id', $userId);
    $query->execute();
    $user_roles = $query->fetchAll();

    return $user_roles;
  }

  public function getRole($roleId)
  {
    $query = $this->getDb()->prepare('SELECT role_name FROM role WHERE role_id=:role_id');
    $query->bindParam(':role_id', $roleId);
    $query->execute();
    $role_name = $query->fetch();

    return $role_name;
  }
}
