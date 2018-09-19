<?php

namespace Models;

use Entities\BookEntity;

class BookModel extends BasicModel
{

  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Get a book by id.
   *
   * @param int $id
   *
   * @return BookEntity|null
   */
  public function get($id)
  {
    $query = $this->dsql_connection->dsql();
    $result = $query->table('books')
      ->where('id', '=', $id)
      ->getRow();
    $book = NULL;
    if ($result) {
      $book = new BookEntity(array(
        "id" => $result['id'],
        "title" => $result['title'],
        "description" => $result['description'],
        "rating" => $result['rating'],
        "ISBN_13" => $result['ISBN_13'],
        "ISBN_10" => $result['ISBN_10'],
        "image" => $result['image'],
        "language" => $result['language'],
        "price" => $result['price'],
        "currency" => $result['currency'],
        "buy_link" => $result['buy_link']
      ));
      }
      return $book;
  }

  /**
   * Creates a book into books table.
   *
   * @param BookEntity $book
   *   Book object.
   *
   * @return bool
   */
  public function save($book)
  {
    $query = $this->dsql_connection->dsql();
    $result = $query->table('books')
      ->set('title', $book->getTitle())
      ->set('description', $book->getDescription())
      ->set('rating', $book->getRating())
      ->set('ISBN_13', $book->getISBN13())
      ->set('ISBN_10', $book->getISBN10())
      ->set('image', $book->getImage())
      ->set('language', $book->getLanguage())
      ->set('price', $book->getPrice())
      ->set('currency', $book->getCurrency())
      ->set('buy_link', $book->getBuyLink())
      ->insert();
    return $result;
  }

  /**
   * Find a book by title
   *
   * @param string $title
   *   Book's title.
   *
   * @return BookEntity|null
   */
  public function find($title)
  {
    $query = $this->dsql_connection->dsql();
    $result = $query
      ->table('books')
      ->where('title', "=", $title)
      ->getRow();
    $book = NULL;
    if ($result) {
      $book = new BookEntity(array(
        "id" => $result['id'],
        "title" => $result['title'],
        "description" => $result['description'],
        "rating" => $result['rating'],
        "ISBN_13" => $result['ISBN_13'],
        "ISBN_10" => $result['ISBN_10'],
        "image" => $result['image'],
        "language" => $result['language'],
        "price" => $result['price'],
        "currency" => $result['currency'],
        "buy_link" => $result['buy_link']
      ));
    }
    return $book;
  }
}