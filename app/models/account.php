<?php

class Account extends BaseModel {

  public $id, $email, $password, $surname, $othernames, $created, $accounttype;

  public function __construct($attributes) {
    parent::__construct($attributes);
    $this->validators = array('validate_email');
  }

  public static function authenticate($email, $password) {
    $query = DB::connection()->prepare('SELECT * FROM Account WHERE email = :email AND password = :password LIMIT 1');
    $query->execute(array('email' => $email, 'password' => $password));
    $row = $query->fetch();
    if ($row) {
      $account = new Account(array(
          'id' => $row['id'],
          'email' => $row['email'],
          'password' => $row['password'],
          'surname' => $row['surname'],
          'othernames' => $row['othernames'],
          'created' => $row['created'],
          'accounttype' => $row['accounttype']
      ));
      return $account;
    } else {
      return null;
    }
  }

  public static function find($id) {
    $query = DB::connection()->prepare('SELECT * FROM Account WHERE id = :id LIMIT 1');
    $query->execute(array('id' => $id));
    $row = $query->fetch();
    if ($row) {
      $account = new Account(array(
          'id' => $row['id'],
          'email' => $row['email'],
          'password' => $row['password'],
          'surname' => $row['surname'],
          'othernames' => $row['othernames'],
          'created' => $row['created'],
          'accounttype' => $row['accounttype']
      ));
      return $account;
    }
    return null;
  }

  public function validate_email($email) {
    $errors = array();
    //toteutetaan myöhemmin
    return $errors;
  }

}
