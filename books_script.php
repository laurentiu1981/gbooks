<?php


use scripts\BooksAPI;

define('SITE_ROOT', getcwd());
include_once(SITE_ROOT . '/includes/bootstrap.php');

if ($argc !== 4) {
  trigger_error('you have to give 3 arguments');
  exit();
}

$title = $argv[1];
$category = $argv[2];
$author = $argv[3];

if ($argv[1] === '' && $argv[2] === '' && $argv[3] === '') {
  trigger_error('you have to give at least 1 not empty argument');
  exit();
}

$booksAPI = new BooksAPI($title, $author, $category);
$booksAPI->saveBooksToDatabase();