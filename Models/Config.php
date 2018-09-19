<?php

namespace Models;

class Config
{
  public function __construct()
  {
    $this->dsql_connection = db_get_dsql_connection();
  }

  /**
   * Save a pair of name,value configuration.
   *
   * @param string $name
   *      Configuration name.
   * @param int $value
   *      Configuration name.
   *
   * @throws \atk4\dsql\Exception
   */
  public function set($name, $value)
  {
    $query = $this->dsql_connection->dsql();
    $nameExists = $query->table('configuration')
      ->where('name', '=', $name)
      ->getRow();
    if ($nameExists) {
      $query = $this->dsql_connection->dsql();
      $query->table('configuration')
        ->where('name', "=", $name)
        ->set('value', serialize($value))
        ->update();
    } else {
      $query = $this->dsql_connection->dsql();
      $query->table('configuration')
        ->set('name', $name)
        ->set('value', serialize($value))
        ->insert();
    }

  }

  /**
   * Get the value of a given configuration.
   *
   * @param string $name
   *      Configuration name.
   *
   * @return string
   *     The value of the requested configuration.
   *
   * @throws \atk4\dsql\Exception
   */
  public function get($name)
  {
    $query = $this->dsql_connection->dsql();
    $result = $query->table('configuration')
      ->where('name', '=', $name)
      ->getRow();
    $value = NULL;
    if ($result) {
      $value = unserialize($result['value']);
    }
    return $value;
  }

  /**
   * Save multiple configurations.
   *
   * @param array $array
   *
   * @throws \atk4\dsql\Exception
   */
  public function setMultiple($array)
  {
    foreach ($array as $key => $value) {
      $this->set($key, $value);
    }
  }

  /**
   * Check if configurations are valid.
   *
   * @param string $googleApi
   * @param int $maxBooks
   *
   * @return bool
   */
  public function isConfigValid($googleApi, $maxBooks)
  {
    $messages = array();
    if (filter_var($googleApi, FILTER_VALIDATE_URL) === FALSE) {
      $messages[] = 'Invalid Google Api Endpoint.';
    }
    if (filter_var($maxBooks, FILTER_VALIDATE_INT) === FALSE || $maxBooks < 0) {
      $messages[] = 'Invalid Default Max books results per page.';
    }
    set_error_messages($messages);
    return empty($messages);
  }


}