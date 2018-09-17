<?php

namespace Controllers;


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
		$this->content = $this->render('/views/home/home_content.tpl.php');
		$sidebar = $this->render('/views/forms/home_search_form.tpl.php');
		$this->renderLayout('/views/layouts/sidebar_page.tpl.php', array('sidebar' => $sidebar));
	}
}