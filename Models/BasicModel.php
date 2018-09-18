<?php

namespace Models;

class BasicModel
{

  public function __construct()
  {
    $this->db = db_get_connection();
    $this->dsql_connection = db_get_dsql_connection();
  }

  /**
   * Executes an sql statement.
   *
   * @param string $sql
   *    Sql statement to be executed.
   *
   * @param array $data
   *    Array of parameters to be passed to the sql statement.
   *
   * @return boolean
   *    True on success, false otherwise.
   */
  protected function executeStatement($sql, $data = NULL)
  {
    $statement = $this->db->prepare($sql);
    try {
      $statement->execute($data);
    } catch (Exception $e) {
    }
    return $statement;
  }
}