<?php

abstract class DatabaseManager
{
  private $db;

  public function __construct(string $host = 'localhost', string $name = 'python', string $user = 'root', string $password = '')
  {
    try
    {
      $this->db = new PDO('mysql:host='.$host.';dbname='.$name.';charset=utf8', $user, $password);
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
      die('Connection error: ' . $e->getMessage() );
    }
  }

  public function getDb(): PDO
  {
    return $this->db;
  }
}
