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
    $errors = $this->validationMessages($_POST);
    $books = [];
    if (empty($errors)) {
      $bookModel = new BookModel();
      $authors = !empty($_POST['author']) ? $_POST['author'] : array();
      $categories = !empty($_POST['category']) ? $_POST['category'] : array();
      $booksEntity = $bookModel->generalFindBy($_POST['title'], $_POST['price-from'], $_POST['price-to'], $authors, $categories);
      $books = [];
      foreach ($booksEntity as $book) {
        $books[] = $book->jsonSerialize();
      }
    }
    $result = array("errors" => $errors, "books" => $books);
    header("Content-Type: application/json");
    $json = json_encode($result);
    echo $json;
    exit();
  }


  /**
   * Validate request parameters.
   * @param $params
   *    Request method.
   * @return array
   *    validation error messages.
   */
  public function validationMessages($params)
  {
    $messages = array();
    if (!empty($params['price-from']) && !is_numeric($params['price-from'])) {
      $messages[] = "From price is not numeric";
    }
    if (!empty($params['price-to']) && !is_numeric(($params['price-to']))) {
      $messages[] = "To price is not numeric";
    }
    return $messages;
  }

}