<?php

/**
 * Get PDO object.
 *
 * @return PDO
 */
function db_get_connection() {
  global $conf;
  $dbInfo = "mysql:host=localhost;port=" . $conf['database']['port'] . ";dbname=" . $conf['database']['db_name'];
  $dbUser = $conf['database']['user'];
  $dbPassword = $conf['database']['password'];
  $db = new PDO( $dbInfo, $dbUser, $dbPassword );
  $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  return $db;
}