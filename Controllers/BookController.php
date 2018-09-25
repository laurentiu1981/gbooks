<?php

namespace Controllers;


use Entities\BookEntity;
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
    if (!empty($_POST)) {
      $bookModel = new BookModel();
      $bookModel->deleteBook($id);
      set_message('Deleted successfully', 'status');
      redirect("/admin");
    } else {
      $this->content = $this->render('/views/books/delete_book_page.tpl.php');
      $this->renderLayout('/views/layouts/basic.tpl.php');
    }
  }

  /**
   * Callback for /admin/book/edit/%id route.
   */
  public function editPageAction($id)
  {
    $bookModel = new BookModel();
    if (!empty($_POST)) {
      $_POST["buy_link"] = $_POST["buy-link"];
      $bookModel->update(new BookEntity($_POST));
      if (empty(get_messages()))
        set_message('Book successfully updated!', 'status');
    }
    $book = $bookModel->get($id);
    $this->title = $book->getTitle();
    $messages = render_messages(get_messages());
    $this->content = $this->render('/views/books/edit_book_page.tpl.php', array('book' => $book));
    $this->renderLayout('/views/layouts/basic.tpl.php', array('messages' => $messages));
  }


}
