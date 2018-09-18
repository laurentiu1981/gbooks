<?php


use Entities\TermEntity;
use Models\TermModel;

define('SITE_ROOT', getcwd());
include_once(SITE_ROOT . '/includes/bootstrap.php');
$termModel = new TermModel();

$term = new TermEntity(array( "vocabulary" => "categories", "name" => "Science"));
$termModel->save($term);

$term1 = $termModel->get(4);

print_r($term1);