<?php

namespace Controllers;


class HomeController extends BasicController {

  public function __construct() {
    parent::__construct();
    $this->title = "Homepage";
  }

  /**
   * Callback for /home route.
   */
  public function homePageAction() {
    $this->content = 'Homepage dummy content';
    $this->renderLayout('/views/layouts/basic.tpl.php');
  }
}