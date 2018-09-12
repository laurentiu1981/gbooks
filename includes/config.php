<?php

global $conf;

$conf = array();
$conf['database'] = array(
  'db_name' => 'gbooks',
  'user' => 'root',
  'password' => '',
  'port' => '3306',
);

if (file_exists(SITE_ROOT . '/config/local_config.php')) {
  require_once SITE_ROOT . '/config/local_config.php';
}