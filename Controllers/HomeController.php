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
    $authors = $termModel->getTermNamesByVocabulary("authors");
    $categories = $termModel->getTermNamesByVocabulary("categories");
    $options = "";
    $optionsCategories = "";
    foreach ($authors as $author)
      $options .= "<option value='" . $author["tid"] . "'>" . $author["name"] . "</option>";
    foreach ($categories as $category)
      $optionsCategories .= "<option value='" . $category["tid"] . "'>" . $category["name"] . "</option>";
    $this->addScript("homepage_chosen.js");
    $this->content = $this->render('/views/home/home_content.tpl.php');
    $sidebar = $this->render('/views/forms/home_search_form.tpl.php', array('options' => $options, 'optionsCategories' => $optionsCategories));
    $this->renderLayout('/views/layouts/sidebar_page.tpl.php', array('sidebar' => $sidebar));
  }
}