<?php

namespace Controllers;


use Models\BookModel;

class Services extends BasicController
{
  /**
   * Action for admin search.
   *
   * @return json
   *      Json of all books after filter, and error messages.
   *
   * @throws \atk4\dsql\Exception
   */
  public function searchPostAction()
  {
    $errors = $this->validationMessages();
    $books = [];
    if (empty($errors)) {
      $bookModel = new BookModel();
      $booksEntity = $bookModel->generalFindBy($_POST['title'], $_POST['price-from'], $_POST['price-to'], $_POST['author']);
      $books = [];
      foreach ($booksEntity as $book) {
        $books[] = array("title" => $book->getTitle(), "image" => $book->getImage(), "link" => $book->getBuyLink(), "authors" => $book->getAuthors());
      }
    }
    $result = array("errors" => $errors, "books" => $books);
    $json = json_encode($result);
    echo $json;
    exit(1);
  }


  /**
   * Validate Post request parameters.
   *
   * @return array
   *    validation error messages.
   */
  public function validationMessages()
  {
    $messages = array();
    if (!empty($_POST['price-from']) && !is_numeric($_POST['price-from'])) {
      $messages[] = "From price is not numeric";
    }
    if (!empty($_POST['price-to']) && !is_numeric(($_POST['price-to']))) {
      $messages[] = "To price is not numeric";
    }
    return $messages;
  }

}