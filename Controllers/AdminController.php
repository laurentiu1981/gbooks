<?php

namespace Controllers;

class AdminController extends BasicController
{

  public function __construct()
  {
    parent::__construct();
    $this->title = "Admin page";
  }

  /**
   * Callback for /admin route.
   */
  public function adminPageAction()
  {
    $this->content = $this->render('/views/admin/admin_content.tpl.php');
    $sidebar = $this->render('/views/forms/admin_search_form.tpl.php');
    $this->renderLayout('/views/layouts/sidebar_page.tpl.php', array('sidebar' => $sidebar));
  }


}