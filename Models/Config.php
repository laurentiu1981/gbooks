<?php

namespace Models;

class Config extends BasicModel
{
  public function __construct()
  {
    parent::__construct();
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
   * @param string $default
   *      Default value for configuration.
   *
   * @return string
   *     The value of the requested configuration.
   * @throws \atk4\dsql\Exception
   */
  public function get($name, $default = NULL)
  {
    $query = $this->dsql_connection->dsql();
    $result = $query->table('configuration')
      ->where('name', '=', $name)
      ->getRow();
    $value = $default;
    if ($result) {
      $value = unserialize($result['value']);
    }
    return $value;
  }

  /**
   * Save multiple configurations.
   *
   * @param array $variables
   *
   * @throws \atk4\dsql\Exception
   */
  public function setMultiple($variables)
  {
    foreach ($variables as $key => $value) {
      $this->set($key, $value);
    }
  }

  /**
   * Check if configurations are valid.
   *
   * @param array $variables
   *
   * @return bool
   */
  public function isConfigValid($variables)
  {
    $messages = array();
    if (filter_var($variables['google_api'], FILTER_VALIDATE_URL) === FALSE) {
      $messages[] = 'Invalid Google Api Endpoint.';
    }
    if (filter_var($variables['max_books'], FILTER_VALIDATE_INT) === FALSE || $variables['max_books'] < 0) {
      $messages[] = 'Invalid Default Max books results per page.';
    }
    set_error_messages($messages);
    return empty($messages);
  }


}