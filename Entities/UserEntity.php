<?php

namespace Entities;

class UserEntity
{
  private $user_id;
  private $email;
  private $password;

  public function __construct($params)
  {
    foreach ($params as $key => $value) {
      $this->{$key} = $value;
    }
  }

  public function getUserId()
  {
    return $this->user_id;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function setUserId($new_id)
  {
    $this->user_id = $new_id;
  }

  public function setEmail($new_email)
  {
    $this->email = $new_email;
  }

  public function setPassword($new_password)
  {
    $this->password = $new_password;
  }

  /*
   * Updates session with current user.
   */
  public function updateSession()
  {
    if (!isset($_SESSION)) {
      session_start();
    }
    $_SESSION['user'] = $this;
  }
}