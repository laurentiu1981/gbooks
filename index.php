<?php

define('SITE_ROOT', getcwd());
include_once (SITE_ROOT . '/includes/bootstrap.php');

gbooks_routes_execute_handler();
