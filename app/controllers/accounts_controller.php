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
      Redirect::to('/account/' . $account->id, array('message' => 'Tervetuloa takaisin ' . $account->email . '!'));
    }
  }

  public static function logout() {
    $_SESSION['user'] = null;
    Redirect::to('/', array('message' => 'Olet kirjautunut ulos!'));
  }

  public static function show($id) {
    self::check_logged_in();
    $account = Account::find($id);
    View::make('account/show.html', array('account' => $account));
  }

  public static function index() {
    self::check_logged_in();
    $account = Account::find($_SESSION['user']);
    $accounts = array();
    if ($account->accounttype == 1) {
      $accounts = Account::all();
    } else {
      $accounts[] = $account;
    }
    View::make('account/index.html', array('accounts' => $accounts));
  }

}
