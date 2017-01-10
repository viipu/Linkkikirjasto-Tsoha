<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
//   	  View::make('home.html');
        View::make('suunnitelmat/index.html');
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
      echo 'Hello World! Hiekkalaatikko!';
//        View::make('helloworld.html');

        $logi = Item::find(1);
        $items = Item::all();
        $testi = new Item(array(
            'title' => '',
            'itemtype' => '',
            'otherdetails' => ''
        ));
         $errors = $testi->errors();
         
        $ada = Account::find(1);
        $kirj = Account::authenticate('Ada@ada.fi', '123');
        $eikirj = Account::authenticate('Ada@ada.fi', '1234');
        // Kint-luokan dump-metodi tulostaa muuttujan arvon
        Kint::dump($items);
        Kint::dump($logi);
        Kint::dump($errors);
        Kint::dump($ada);
        Kint::dump($kirj);
        Kint::dump($eikirj);
    }

    public static function items_list() {
        View::make('suunnitelmat/items_list.html');
    }

    public static function item_show() {
        View::make('suunnitelmat/item_show.html');
    }

    public static function loans_list() {
        View::make('suunnitelmat/loans_list.html');
    }

    public static function login() {
        View::make('suunnitelmat/login.html');
    }

//}
}
