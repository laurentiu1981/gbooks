<?php

namespace Entities;

class BasicModel
{
  protected $db;

  public function __construct()
  {
    $this->db = db_get_connection();
  }

  protected function makeStatement($sql, $data = NULL)
  {
    $statement = $this->db->prepare($sql);
    try {
      $statement->execute($data);
    } catch (Exception $e) {
      trigger_error($e->getMessage());
    }
    return $statement;
  }
}