<?php

namespace Controllers;

class AdminController  extends BasicController
{

  public function __construct()
  {
    parent::__construct();
    $this->title = "Admin page";
  }

  /**
   * Callback for /admin route.
   */
  public function adminPageAction() {
    $this->content = $this->render('/views/layouts/admin_content.php');
    $sidebar = $this->render('/views/layouts/admin_sidebar.php');
    $this->renderLayout('/views/layouts/sidebar_page.tpl.php',array('sidebar'=>$sidebar));
  }


}