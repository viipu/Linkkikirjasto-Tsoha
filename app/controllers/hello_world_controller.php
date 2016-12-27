<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
//   	  View::make('home.html');
        View::make('suunnitelmat/index.html');
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
//      echo 'Hello World! Hiekkalaatikko!';
        View::make('helloworld.html');
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
