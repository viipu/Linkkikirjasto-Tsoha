<?php

class AccountController extends BaseController {

  public static function login() {
    View::make('account/login.html');
  }

  public static function handle_login() {
    $params = $_POST;

    $account = Account::authenticate($params['email'], $params['password']);

    if (!$account) {
      View::make('account/login.html', array('error' => 'Väärä sähköpostiosoite tai salasana!', 'email' => $params['email']));
    } else {
      $_SESSION['user'] = $account->id;
//      <!--Ongelma? -->

      Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $account->email . '!'));
    }
  }

  public static function show($id) {
    $account = Account::find($id);
    View::make('account/show.html', array('account' => $account));
  }
}
