<?php


use scripts\BooksAPI;

define('SITE_ROOT', getcwd());
include_once(SITE_ROOT . '/includes/bootstrap.php');

// check if there is at least 1 argument
if ($argc === 1) {
  trigger_error('you have to give at least 1 argument');
  exit();
} else if ($argc > 3) {
  trigger_error('you can give at most 2 arguments');
  exit();
}
//set category
if ($argv[1] !== '') {
  $category = $argv[1];
} else {
  trigger_error('you have to give at least 1 argument');
}
//set author
if (isset($argv[2])) {
  $author = $argv[2];
} else
  $author = "";


$booksAPI = new BooksAPI($author, $category);
$books = $booksAPI->getBooks();
print_r($books);
