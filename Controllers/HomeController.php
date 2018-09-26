<?php

namespace Controllers;


use Models\BookModel;
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
    $authorsOptions = gbooks_theme_generate_select_options($termModel->getTermNamesByVocabulary("authors"));
    $categoriesOptions = gbooks_theme_generate_select_options($termModel->getTermNamesByVocabulary("categories"));
    $books = $bookModel->generalFindBy('', '', '', '', '', 12);
    $homepageBooks = gbooks_generate_books($books);
    if (isset($_GET['price-from']) && isset($_GET['price-to'])) {
      $title = $_GET['title'];
      $author = $_GET['author'];
      $category = $_GET['category'];
      $priceFrom = $_GET['price-from'];
      $priceTo = $_GET['price-to'];
      set_search_fields(array('title' => $title,
        'author' => $author,
        'category' => $category,
        'priceFrom' => $priceFrom,
        'priceTo' => $priceTo,
      ));
      if ($bookModel->areValidPrices($priceFrom, $priceTo)) {
        $searchBooks = $bookModel->generalFindBy($title, $priceFrom, $priceTo, $author, $category);
        $homepageBooks = gbooks_generate_books($searchBooks);
        $authorsOptions = gbooks_theme_generate_select_options($termModel->getTermNamesByVocabulary("authors"), get_search_fields()['author']);
        $categoriesOptions = gbooks_theme_generate_select_options($termModel->getTermNamesByVocabulary("categories"), get_search_fields()['category']);
      }
    }
    $searchFields = get_search_fields();
    unset_search_fields($searchFields);
    $this->content = $this->render('/views/home/home_content.tpl.php', array('homepageBooks' => $homepageBooks));
    $sidebar = $this->render('/views/forms/home_search_form.tpl.php', array('searchFields' => $searchFields, 'options' => $authorsOptions, 'optionsCategories' => $categoriesOptions, 'messages' => render_messages(get_messages())));
    $this->renderLayout('/views/layouts/sidebar_page.tpl.php', array('sidebar' => $sidebar));
  }
}