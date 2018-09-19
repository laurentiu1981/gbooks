<?php

/**
 * Get PDO object.
 *
 * @return PDO
 */
function db_get_connection()
{
  global $conf;
  $dbInfo = "mysql:host=localhost;port=" . $conf['database']['port'] . ";dbname=" . $conf['database']['db_name'];
  $dbUser = $conf['database']['user'];
  $dbPassword = $conf['database']['password'];
  $db = new PDO($dbInfo, $dbUser, $dbPassword);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $db;
}

/**
 * Gets DSQL connection.
 *
 * @return \atk4\dsql\Connection
 */
function db_get_dsql_connection()
{
  global $conf;
  $dsn = "mysql:host=localhost;port=" . $conf['database']['port'] . ";dbname=" . $conf['database']['db_name'];
  $username = $conf['database']['user'];
  $password = $conf['database']['password'];
  $db = atk4\dsql\Connection::connect($dsn, $username, $password);
  return $db;
}