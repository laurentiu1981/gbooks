<?php

namespace Controllers;

use models\User;

class UserAuthenticationController extends BasicController
{

  public function __construct()
  {
    parent::__construct();
    $this->title = "User Authentication";
  }

  /**
   * Callback for /register route.
   */
  public function registerPageAction()
  {
    $message = render_messages(get_messages());
    $this->content = $this->render('views/forms/register.tpl.php', array('message' => $message));
    $this->renderLayout('/views/layouts/basic.tpl.php');
  }

  /**
   * Registers user if credentials are valid.
   */
  public function registerPost()
  {
    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm-password'])) {
      $email = $_POST['email'];
      $password = $_POST['password'];
      $passwordConfirmation = $_POST['confirm-password'];
      $db = db_get_connection();
      $user = new User();
      if ($user->isRegistrationValid($email, $password, $passwordConfirmation)) {
        $user->createUser($email, $password);
        set_message('User successfully created!', 'status');
        redirect('/admin');
      }
    }
    $this->registerPageAction();
  }

  /**
   * Callback for /login route.
   */
  public function loginPageAction()
  {
    $message = render_messages(get_messages());
    $this->content = $this->render('views/forms/login.tpl.php', array('message' => $message));
    $this->renderLayout('/views/layouts/basic.tpl.php');
  }

  /**
   * Logs in user if credentials are valid.
   */
  public function loginPost()
  {
    if (isset($_POST['email']) && isset($_POST['password'])) {
      $email = $_POST['email'];
      $password = $_POST['password'];
      $db = db_get_connection();
      $user = new User();
      if ($user->areValidCredentials($email, $password)) {
        set_message('Logged in successfully!', 'status');
        redirect('/admin');
      }
    }
    $this->loginPageAction();
  }
}