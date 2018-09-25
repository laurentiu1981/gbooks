<?php

namespace Controllers;


use Models\BookModel;

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
    if ($book->getRating() === NULL) {
      $book->setRating('N/A');
      $ratingStars = '';
    } else {
      $ratingStars = gbooks_theme_generate_rating_stars($book->getRating());
    }
    $this->title = $book->getTitle();
    $this->content = $this->render('/views/books/individual_book_page.tpl.php', array('book' => $book, 'ratingStars' => $ratingStars));
    $this->renderLayout('/views/layouts/basic.tpl.php');
  }

  public function deletePage($id)
  {
    if (!isset($_GET['confirmed'])) {
      $url = $_SERVER['REQUEST_URI'];
      echo "
      <script type='text/javascript'>
          var response=confirm('Are you sure you want to delete this book?');
          if (response==true){
              window.location.href='" . $url . "?confirmed=1';
          }
      </script>";
    } elseif ($_GET['confirmed'] == 1) {
      $bookModel = new BookModel();
      $bookModel->deleteBook($id);
    }
  }
}