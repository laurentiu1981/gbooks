<?php
/**
 * Created by PhpStorm.
 * User: Sara Boanca
 * Date: 14.09.2018
 * Time: 10:05
 */

namespace Controllers;


class UserAuthenticationController extends BasicController{

	public function __construct() {
		parent::__construct();
		$this->title = "User Authentication";
	}

	/**
	 * Callback for /register route.
	 */
	public function registerAction() {
		$this->content = 'Register content';
		$this->renderLayout('/views/layouts/register.tpl.php');
	}

	/**
	 * Callback for /login route.
	 */
	public function loginAction() {
		$this->content = 'Login content';
		$this->renderLayout('/views/layouts/login.tpl.php');
	}
}