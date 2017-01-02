<?php

class ItemController extends BaseController {

    public static function index() {
        $items = Item::all();
        View::make('item/index.html', array('items' => $items));
    }

    public static function show($id) {
        $item = Item::find($id);
        View::make('item/show.html', array('item' => $item));
    }

    public static function store() {
        $params = $_POST;
        $item = new Item(array(
            'title' => $params['title'],
            'itemtype' => $params['itemtype'],
            'otherdetails' => $params['otherdetails']
        ));

        // Kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
        $item->save();

        // Ohjataan käyttäjä lisäyksen jälkeen pelin esittelysivulle
        Redirect::to('/item/' . $item->id, array('message' => 'Uusi aineisto on lisätty kirjastoon!'));
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
        echo 'Hello World! Hiekkalaatikko!';
//        View::make('helloworld.html');

        $logi = Item::find(1);
        $items = Item::all();
        // Kint-luokan dump-metodi tulostaa muuttujan arvon
        Kint::dump($items);
        Kint::dump($logi);
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
