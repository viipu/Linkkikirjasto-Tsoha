<?php

class BaseController {

  public static function get_user_logged_in() {
    if (isset($_SESSION['user'])) {
      $user_id = $_SESSION['user'];
      $user = Account::find($user_id);

      return $user;
    }

    // Käyttäjä ei ole kirjautunut sisään
    return null;
  }

  public static function check_logged_in() {
    if (!isset($_SESSION['user'])) {
      Redirect::to('/login', array('message' => 'Kirjaudu ensin sisään!'));
    }
  }

  public static function check_authorized() {
    if (!isset($_SESSION['user'])) {
      Redirect::to('/login', array('message' => 'Kirjaudu ensin sisään!'));
    } else {
      $user = self::get_user_logged_in();
      if ($user->accounttype != 1) {
        Redirect::to('/login', array('message' => 'Kirjaudu sisään pääkäyttäjänä!'));
      }
    }
  }

}
