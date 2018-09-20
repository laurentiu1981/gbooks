<?php

namespace Controllers;

use models\UserModel;

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
    $messages = render_messages(get_messages());
    $this->content = $this->render('views/forms/register.tpl.php', array('messages' => $messages));
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
      $user = new UserModel();
      if ($user->isRegistrationValid($email, $password, $passwordConfirmation)) {
        $user->createUser($email, $password);
        set_message('User successfully created!', 'status');
        redirect('/login');
      }
    }
    $this->registerPageAction();
  }

  /**
   * Callback for /login route.
   */
  public function loginPageAction()
  {
    $messages = render_messages(get_messages());
    $this->content = $this->render('views/forms/login.tpl.php', array('messages' => $messages));
    $this->renderLayout('/views/layouts/basic.tpl.php');
  }

  /**
   * Callback for /logout route.
   */
  public function logoutPageAction()
  {
    $userModel = new UserModel();
    $userModel->logout();
    redirect('/');
  }

  /**
   * Logs in user if credentials are valid.
   */
  public function loginPost()
  {
    if (isset($_POST['email']) && isset($_POST['password'])) {
      $email = $_POST['email'];
      $password = $_POST['password'];
      $userModel = new UserModel();
      if ($userModel->areValidCredentials($email, $password)) {
        $user = $userModel->loadByEmail($email);
        $user->updateSession();
        set_message('Logged in successfully!', 'status');
        redirect('/admin');
      }
    }
    $this->loginPageAction();
  }
}