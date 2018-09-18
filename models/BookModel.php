<?php

namespace models;

use Entities\BookEntity;

class BookModel extends BasicModel
{


  public function __construct()
  {
    parent::__construct();
  }

  public function get($id)
  {
    $sql = "SELECT * FROM books WHERE id = ?";
    $data = array($id);
    $statement = $this->executeStatement($sql, $data);
    $row = $statement->fetchObject();
    $book = NULL;
    if ($row) {
      $book = new BookEntity(array(
        'id' => $row->id,
        'title' => $row->title,
        'description' => $row->description,
        'rating' => $row->rating,
        'ISBN_13' => $row->ISBN_13,
        'ISBN_10' => $row->ISBN_10,
        'image' => $row->image,
        'language' => $row->language,
        'price' => $row->price,
        'currency' => $row->currency,
        'buy_link' => $row->buy_link
      ));
    }
    return $book;
  }

  public function save($book)
  {
    $sql = "INSERT INTO books (title, description, rating, ISBN_13, ISBN_10, image, language, price, currency, buy_link) VALUES (?,?,?,?,?,?,?,?,?,?)";
    $data = array($book->getTitle(), $book->getDescription(), $book->getRating(), $book->getISBN13(), $book->getISBN10(), $book->getImage(), $book->getLanguage(), $book->getPrice(), $book->getCurrency(), $book->getBuyLink());
    $statement = $this->executeStatement($sql, $data);
    return $statement;
  }

  public function find($title)
  {
    $sql = "SELECT * FROM books WHERE title = ?";
    $data = array($title);
    $statement = $this->executeStatement($sql, $data);
    $row = $statement->fetchObject();
    $book = NULL;
    if ($row) {
      $book = new BookEntity(array(
        'id' => $row->id,
        'title' => $row->title,
        'description' => $row->description,
        'rating' => $row->rating,
        'ISBN_13' => $row->ISBN_13,
        'ISBN_10' => $row->ISBN_10,
        'image' => $row->image,
        'language' => $row->language,
        'price' => $row->price,
        'currency' => $row->currency,
        'buy_link' => $row->buy_link
      ));
    }
    return $book;
  }

}