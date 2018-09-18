<?php

namespace Models;

use Entities\UserEntity;

class UserModel extends BasicModel
{

  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Creates a new user entry into users table.
   *
   * @param string $email
   *    User email.
   * @param string $password
   *    User password.
   */
  public function createUser($email, $password)
  {
    $permission = $this->isEmailUnique($email);
    if ($permission) {
      $query = $this->dsql_connection->dsql();
      $result = $query->table('users')
        ->set('email', $email)
        ->set('password', MD5($password))
        ->insert();
    }
  }

  /**
   * Loads user entity.
   *
   * @param string $email
   *    User email.
   *
   * @return UserEntity
   */
  public function loadByEmail($email)
  {
    $query = $this->dsql_connection->dsql();
    $result = $query->table('users')
      ->where('email', '=', $email)
      ->getRow();
    return new UserEntity(array(
      'user_id' => $result['user_id'],
      'email' => $result['email']
    ));
  }

  /**
   * Validates user email introduced at registration against duplication.
   *
   * @param string $email
   *    User email.
   *
   * @return boolean
   *    True if email is not already used, false otherwise.
   */
  public function isEmailUnique($email)
  {
    $query = $this->dsql_connection->dsql();
    $result = $query->table('users')
      ->where('email', '=', $email)
      ->getRow();
    return empty($result);
  }

  /**
   * Validates credentials introduced by user at registration.
   *
   * @param string $email
   *    User email.
   *
   * @param string $password
   *    User password.
   *
   * @param string $passwordConfirmation
   *    User password confirmation.
   *
   * @return boolean
   *    True if credentials are valid, false otherwise.
   */
  public function isRegistrationValid($email, $password, $passwordConfirmation)
  {
    $messages = array();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $messages[] = 'Invalid e-mail used.';
    }
    if (strlen($password) < 6) {
      $messages[] = 'Invalid password length.';
    }
    if ($password !== $passwordConfirmation) {
      $messages[] = 'Password confirmation does not match password.';
    }

    if (!$this->isEmailUnique($email)) {
      $messages[] = 'E-mail address already used.';
    }

    set_error_messages($messages);
    return empty($messages);
  }

  /**
   * Validates credentials introduced by user at login to be consistent with a database entry in table users.
   *
   * @param string $email
   *    User email.
   *
   * @param string $password
   *    User password.
   *
   * @return boolean
   *    True if credentials match a valid user, false otherwise.
   */
  public function areValidCredentials($email, $password)
  {
    $query = $this->dsql_connection->dsql();
    $result = $query->table('users')
      ->where('email', '=', $email)
      ->where('password', '=', MD5($password))
      ->get();
    $messages = array();
    if (sizeof($result) !== 1) {
      $messages[] = 'Invalid username and password.';
    }
    set_error_messages($messages);
    return empty($messages);
  }
}