<?php

namespace Controllers;


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
    $authorsOptions = gbooks_theme_generate_select_options($termModel->getTermNamesByVocabulary("authors"));
    $categoriesOptions = gbooks_theme_generate_select_options($termModel->getTermNamesByVocabulary("categories"));
    $this->content = $this->render('/views/home/home_content.tpl.php');
    $sidebar = $this->render('/views/forms/home_search_form.tpl.php', array('options' => $authorsOptions, 'optionsCategories' => $categoriesOptions));
    $this->renderLayout('/views/layouts/sidebar_page.tpl.php', array('sidebar' => $sidebar));
  }
}