<?php

namespace Controllers;


use Models\BookModel;
use Models\TermModel;

class BookController extends BasicController
{
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Callback for /book/%id route.
   */
  public function bookPageAction($id)
  {
    $bookModel = new BookModel();
    $book = $bookModel->get($id);
    $authors = $bookModel->getTermNames($id, 'authors');
    $categories = $bookModel->getTermNames($id, 'categories');
    $this->content = $this->render('/views/books/individual_book_page.tpl.php', array('book' => $book, 'authors' => $authors, 'categories' => $categories));
    $this->renderLayout('/views/layouts/basic.tpl.php');
  }
}