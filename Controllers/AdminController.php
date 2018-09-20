<?php

namespace Controllers;

use Models\Config;

class AdminController extends BasicController
{

  public function __construct()
  {
    parent::__construct();
    global $user;
    $this->title = "Admin page";
    get_session_user();
    if ($user === NULL) {
      redirect("/login");
    }
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

  /**
   * Callback for /admin/settings route.
   */
  public function adminConfigPageAction()
  {
    $message = render_messages(get_messages());
    $config = new Config();
    $gAPI = $config->get("google_api_endpoint");
    $maxBook = $config->get("customer_default_max_books_results_per_page", 10);
    $this->content = $this->render('/views/forms/admin_config_form.tpl.php', array('message' => $message, 'gAPI' => $gAPI, "maxBook" => $maxBook));
    $this->renderLayout('/views/layouts/basic.tpl.php');
  }

  /**
   * Callback for /admin/settings POST request.
   */
  public function adminConfigPostAction()
  {
    if (isset($_POST['google_api']) && isset($_POST['max_books'])) {
      $config = new Config();
      if ($config->isConfigValid($_POST)) {
        $config->setMultiple(array(
          "google_api_endpoint" => $_POST['google_api'],
          "customer_default_max_books_results_per_page" => intval($_POST['max_books']
          )));
        set_message('Configurations successfully saved!', 'status');
        redirect('/admin/settings');
      }
    }
    $this->adminConfigPageAction();

  }


}