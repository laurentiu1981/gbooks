<?php


use Entities\TermEntity;
use Entities\TermModel;

define('SITE_ROOT', getcwd());
include_once(SITE_ROOT . '/includes/bootstrap.php');

$termModel = new TermModel();

$term = new TermEntity(array("id" => 3, "vocabulary" => "categories", "name" => "Fiction"));
$termModel->save($term);

$term1 = $termModel->findByName("jj");

print_r($term1);