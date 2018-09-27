<?php

namespace Models;

use atk4\core\Exception;
use atk4\dsql\Expression;
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
      $authors = $this->getTermNames($id, 'authors');
      $categories = $this->getTermNames($id, 'categories');
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
        "buy_link" => $result['buy_link'],
        "authors" => $authors,
        "categories" => $categories,
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
  public function generalFindBy($title, $priceFrom, $priceTo, $author, $category)
  {
    $query = $this->dsql_connection->dsql();
    $results = $query
      ->field("id")
      ->field("title")
      ->field("description")
      ->field("rating")
      ->field("ISBN_13")
      ->field("ISBN_10")
      ->field("image")
      ->field("ISBN_13")
      ->field("language")
      ->field("price")
      ->field("currency")
      ->field("buy_link")
      ->field(new Expression("group_concat(fa.term_id) as authorIds"))
      ->field(new Expression("group_concat(fc.term_id) as categoriesIds"))
      ->table('books', "b")
      ->join('field_authors fa', new Expression("b.id=fa.entity_id"), "inner")
      ->join('field_categories fc', new Expression("b.id=fc.entity_id"), "inner");
    if ($title !== "")
      $query->where('b.title', "LIKE", '%' . $title . '%');
    if ($priceFrom !== "")
      $query->where('b.price', ">=", $priceFrom);
    if ($priceTo !== "")
      $query->where('b.price', "<=", $priceTo);
    if ($author !== "")
      $query
        ->join('field_authors fa1', new Expression("b.id=fa1.entity_id"), "inner")
        ->where('fa1.term_id', "=", $author);
    if ($category !== "")
      $query
        ->join('field_categories fc1', new Expression("b.id=fc1.entity_id"), "inner")
        ->where('fc1.term_id', "=", $category);
    $query->group("b.id");
    $query->get();

    $termModel = new TermModel();
    $books = [];
    foreach ($results as $result) {
      $authorsIds = explode(",", $result['authorIds']);
      $categoriesIds = explode(",", $result['categoriesIds']);
      $authorNames = $termModel->getTermNamesByIds($authorsIds);
      $categoryNames = $termModel->getTermNamesByIds($categoriesIds);
      if (!$result['image'])
        $result['image'] = "/images/default.jpeg";
      $books[] = new BookEntity(array(
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
        "buy_link" => $result['buy_link'],
        "authorsIds" => $authorsIds,
        "categoriesIds" => $categoriesIds,
        "authors" => $authorNames,
        "categories" => $categoryNames,
      ));
    }
    return $books;
  }

  /**
   * Get term name for entity with given id.
   *
   * @param $id
   *    Entity id.
   *
   * @param $type
   *    Type of the term (authors/cathegories).
   *
   * @return array
   *    List of terms keyed by tid.
   *
   * @throws \atk4\dsql\Exception
   */
  public function getTermNames($id, $type)
  {
    $query = $this->dsql_connection->dsql();
    $table = 'field_' . $type . ' f';
    $result = $query->table('terms', 't')
      ->field('name')
      ->field('tid')
      ->join($table, new Expression('t.tid=f.term_id'), 'inner')
      ->where('f.entity_id', '=', $id)
      ->get();
    $termNames = [];
    foreach ($result as $termInfo) {
      $termNames[$termInfo['tid']] = $termInfo['name'];
    }
    return $termNames;
  }

  public function deleteBook($id)
  {
    $query = $this->dsql_connection->dsql();
    $query->table('books')
      ->where('id', '=', $id)
      ->delete();
    $query = $this->dsql_connection->dsql();
    $query->table('field_authors')
      ->where('entity_id', '=', $id)
      ->delete();
    $query = $this->dsql_connection->dsql();
    $query->table('field_categories')
      ->where('entity_id', '=', $id)
      ->delete();
  }


  /**
   * Update book.
   *
   * @param int $id
   * @param array $params
   *
   * @throws \atk4\dsql\Exception
   */
  public function updateBook($id, $params)
  {
    $query = $this->dsql_connection->dsql();
    $query->table('books');
    if (isset($params["description"]))
      $query->set("description", $params["description"]);
    $query->where("id", "=", $id)->update();
  }


  /**
   * Check if book is already in the database.
   *
   * @param entity $book
   *
   * @return array/false
   *
   * @throws \atk4\dsql\Exception
   */
  public function checkBook($book)
  {
    $query = $this->dsql_connection->dsql();
    $query->table("books");
    $query2 = $query->orExpr();
    if (!empty($book->getISBN10()))
      $query2->where("ISBN_10", "=", $book->getISBN10());
    if (!empty($book->getISBN13()))
      $query2->where("ISBN_13", "=", $book->getISBN13());

    if (empty($book->getISBN10()) && empty($book->getISBN13()) && !empty($book->getTitle()))
      $query->where("title", "=", $book->getTitle());
    else
      $query->where($query2);
    $result = $query->getRow();
    return $result;
  }

}