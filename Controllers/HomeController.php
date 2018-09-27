<?php

namespace Controllers;


use Models\BookModel;
use Models\Config;
use Models\TermModel;

class HomeController extends BasicController
{

  public function __construct()
  {
    parent::__construct();
    $this->title = "Homepage";
  }

  /**
   * Callback for /home route.
   */
  public function homePageAction()
  {
    $termModel = new TermModel();
    $bookModel = new BookModel();
    $books = array();
    if ($_GET['q'] === '/search') {
      $services = new Services();
      if (empty($services->validationMessages($_GET))) {
        $books = $bookModel->generalFindBy($_GET['title'], $_GET['price-from'], $_GET['price-to'], $_GET['author'], $_GET['category']);
      } else {
        set_error_messages($services->validationMessages($_GET));
      }
    } else {
      $config = new Config();
      $limit = $config->get("customer_default_max_books_results_per_page", 12);
      $books = $bookModel->generalFindBy('', '', '', '', '', $limit);
    }

    $defaultAuthor = isset($_GET['author']) ? $_GET['author'] : '';
    $homepageBooks = gbooks_generate_books($books);
    $authorsOptions = gbooks_theme_generate_select_options(
      $termModel->getTermNamesByVocabulary("authors"),
      $defaultAuthor
    );
    $defaultCategory = isset($_GET['category']) ? $_GET['category'] : '';
    $categoriesOptions = gbooks_theme_generate_select_options(
      $termModel->getTermNamesByVocabulary("categories"),
      $defaultCategory
    );
    $this->content = $this->render('/views/home/home_content.tpl.php', array('homepageBooks' => $homepageBooks));
    $sidebar = $this->render('/views/forms/home_search_form.tpl.php', array(
      'searchFields' => $_GET,
      'options' => $authorsOptions,
      'optionsCategories' => $categoriesOptions,
      'messages' => render_messages(get_messages())
    ));
    $this->renderLayout('/views/layouts/sidebar_page.tpl.php', array('sidebar' => $sidebar));
  }
}