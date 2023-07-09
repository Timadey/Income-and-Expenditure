<?php

namespace app\operations;

/**
 * Account - a class that handles everything related to the user
 * Creates new account for users if they don't exist
 * Handles login and logout, amongst other things
 */

class Account
{
  private Database $db;
  private $uid = NULL;
  private $uname = NULL;
  private $email = NULL;
  private $login = FALSE;

  /**Create an instance of account with the current database connection object */
  public function __construct(Database $db)
  {
    $this->db = $db;
  }
  /**get account user id */
  public function getUid()
  {
    return $this->uid;
  }
  /**get account user name */
  public function getUname()
  {
    return $this->uname;
  }
  /**get account email */
  public function getEmail()
  {
    return $this->email;
  }
  /**get login status */
  public function getLogin()
  {
    return $this->login;
  }
  /**
   * addAccount - adds a new user to the database if it doesn't exist
   * @first_name: first name of the user
   * @last_name: last name of the user
   * @email: email of the user
   * @password: password of the user
   * Return: the id of the new account, -1 if failed to create user
   */
  public function addAccount($first_name, $last_name, $email, $password)
  {
    $error = [];
    $name = $first_name . ' ' . $last_name;
    try {
      /** check if input is valid */
      if (!$this->isNameValid($first_name, 3, 10))
        $error[] = "Name must contain only character of length greater than 3 and less than 10";
      if (!$this->isNameValid($last_name, 3, 10))
        $error[] = "Name must contain only character of length greater than 3 and less than 10";
      if (!$this->isEmailValid($email))
        $error[] = "Invalid Email";
      if (!$this->isPasswordValid($password))
        $error[] = "Password must be greater than 7 characters";

      if (!empty($error)) return $error;

      /** check if user exist */
      $col = array('`user_id`');
      $where = array('`email`' => ':email');
      $value = array(':email' => $email);
      $exist = $this->db->dbGetData($col, "`users`", null, $where, $value);
      if (is_array($exist) && !empty($exist))
        $error[] = "Email already exist, please login";

      if (!empty($error)) return $error;

      /** user doesn't exist, insert into users table */
      $table = "`users`";
      $columns = array("`first_name`", "`last_name`", "`email`", "`password`");
      $password = password_hash($password, PASSWORD_DEFAULT);
      $values = array(
        ':first_name' => $first_name,
        ':last_name' => $last_name,
        ':email' => $email,
        ':password' => $password
      );
      $register = $this->db->insertData($table, $columns, $values);
      // echo $register;
      // exit();
      if ($register > 0)
        return ($register);
      else
        return ["Oops! Registration failed due to technical reasons"];
    } catch (\Exception $err) {
      return ["Oops! Registration failed due to technical reasons"];
    };
  }
  /**
   * login - authenticates user login
   * @email: email of user
   * @password password of user
   * Return: true on success, 1 if a user is logged in already, false on failure
   */
  public function login($email, $password)
  {
    $error = [];
    try {
      if ($this->uid != NULL && $this->login != false) {
        return (1);
      }
      if (!$this->isEmailValid($email)) $error[] = "Invalid email";
      if (!empty($error)) return $error;

      $where = array('`email`' => ':email');
      $value = array(':email' => $email);
      $user = $this->db->dbGetData(null, '`users`', null, $where, $value);

      if (is_array($user) && !empty($user)) {
        $user = $user[0];
        if (password_verify($password, $user['password'])) {
          $this->uid = $user['user_id'];
          $this->uname = $user['first_name'] . ' ' . $user['last_name'];
          $this->email = $user['email'];
          $this->login = true;

          return (true);
        } else {
          $error[] = "Incorrect password";
          return ($error);
        }
      } else {
        $error[] = "User doesn't exist";
        return $error;
      }
    } catch (\Exception $err) {
      return ["Oops! We're experiencing technical issues"];
    }
  }
  /**
   * isNameValid - check if name is valid
   * @name: name to check
   * Return: true or false
   */
  public function isNameValid(string $name, int $min = 4, int $max = 30): bool
  {
    if (strlen($name) > $min && strlen($name) < $max) {
      if (!preg_match("/^[a-zA-Z- ']*$/", $name)) {
        return false;
      } else {
        return true;
      }
    };
    return false;
  }
  /**
   * isPasswordValid - check if password is valid
   * @password: password to check
   * Return: true or false
   */
  public function isPasswordValid($password): bool
  {
    if (strlen($password) > 7) {
      return true;
    };
    return false;
  }
  /**
   * isEmailValid - check if email is valid
   * @email: email to check
   * Return: true or false
   */
  public function isEmailValid($email): bool
  {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return false;
    };
    return true;
  }
  /**
   * isNumValid - check if the input contains only numbers
   * @num: input to check
   * Return: true if valid, otherwise false
   */
  public function isNumValid($num)
  {
    if (preg_match("/^[0-9]*$/", $num)) {
      return true;
    }
    return false;
  }
}
