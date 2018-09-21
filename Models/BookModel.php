<?php

namespace Models;

use atk4\core\Exception;
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
    try {
      $query->table('books')
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
      $book_id = $this->dsql_connection->lastInsertID();

      //save field_authors
      foreach ($book->getAuthorsIds() as $authorId) {
        $this->saveMapping($book_id, $authorId, 'field_authors');
      }
      //save field_categories
      foreach ($book->getCategoriesIds() as $categoryId) {
        $this->saveMapping($book_id, $categoryId, 'field_categories');
      }
      return $book_id;

    } catch (Exception $e) {

    }

  }

  /**
   * Save referenced entities.
   *
   * @param int $entity_id
   *   Book id.
   * @param int $term_id
   *   Term id.
   * @param string $table_name
   *   Database table name.
   *
   * @throws \atk4\dsql\Exception
   */
  public function saveMapping($entity_id, $term_id, $table_name)
  {
    $query = $this->dsql_connection->dsql();
    $query->table($table_name)
      ->set('entity_id', $entity_id)
      ->set('entity_type', 'book')
      ->set('term_id', $term_id)
      ->insert();
  }

  /**
   * Find a book by title
   *
   * @param string $title
   *   Book's title.
   *
   * @return BookEntity|null
   *
   * @throws
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


  /**
   * Filter books.
   *
   * @param string $title
   *        Book title.
   * @param number $priceFrom
   *        Minimum price of book.
   * @param number $priceTo
   *        Maximum price of book.
   * @param number $author
   *        Term id of the author.
   *
   * @return array
   *    List of book entities.
   *
   * @throws \atk4\dsql\Exception
   */
  public function generalFindBy($title, $priceFrom, $priceTo, $author)
  {
    $query = $this->dsql_connection->dsql();
    $sub_query = $this->dsql_connection->dsql();
    $results = $query
      ->table('books', "b")
      ->join('field_authors fa', new Expression("b.id=fa.entity_id"), "inner")
      ->join('terms t', new Expression('t.tid=fa.term_id'), "inner")
      ->join('vocabulary v', new Expression('v.vid=t.vid'), "inner")
      ->where("v.vocabulary", "=", "authors")
      ->where('b.title', "LIKE", '%' . $title . '%');
    if ($priceFrom !== "")
      $query->where('b.price', ">=", $priceFrom);
    if ($priceTo !== "")
      $query->where('b.price', "<=", $priceTo);
    if ($author !== "")
      $query->where('b.id', 'IN',
        $sub_query
          ->field("b.id")
          ->table("books", "b")
          ->join('field_authors fa', new Expression("b.id=fa.entity_id"), "inner")
          ->where('fa.term_id', "LIKE", $author));
    $query->get();


    $books = [];
    $authors = [];
    $bId = NULL;
    $book = NULL;
    foreach ($results as $result) {
      if (is_null($bId) || $bId !== $result['id']) {
        $authors = array($result['name']);
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
        $books[] = $book;
        $book->setAuthors($authors);
        $bId = $result['id'];
      } else {
        $authors[] = $result['name'];
        $book->setAuthors($authors);
      }
    }
    return $books;
  }

}