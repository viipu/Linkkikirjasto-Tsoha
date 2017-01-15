<?php

class ItemController extends BaseController {

  public static function index() {
    $items = Item::all();
    View::make('item/index.html', array('items' => $items));
  }

  public static function show($id) {
    $item = Item::find($id);
    $authors = Author::itemsAuthors($id);
    View::make('item/show.html', array('item' => $item, 'authors' => $authors));
  }

  public static function create() {
    self::check_authorized();
    $authors = Author::all();
    View::make('item/new.html', array('authors' => $authors));
  }

  public static function store() {
    self::check_authorized();
    $params = $_POST;
    $attributes = array(
        'title' => $params['title'],
        'itemtype' => $params['itemtype'],
        'otherdetails' => $params['otherdetails'],
        'authors' => array()
    );
    if (array_key_exists('authors', $params)) {
      $authors = $params['authors'];
      foreach ($authors as $author) {
        $attributes['authors'][] = $author;
      }
    }

    $item = new Item($attributes);
    $errors = $item->errors();

    if (count($errors) == 0) {
      // Ei virheitä, kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
      $item->save();
      // Ohjataan käyttäjä lisäyksen jälkeen aineiston esittelysivulle
      Redirect::to('/item/' . $item->id, array('message' => 'Uusi aineisto on lisätty kirjastoon!'));
    } else {
      // uudessa aineistossa oli jotain vikaa, ohjataan takaisin lomakkeeseen
      View::make('item/new.html', array('errors' => $errors, 'attributes' => $attributes));
    }
  }

  // Aineiston muokkaaminen (lomakkeen esittäminen)
  public static function edit($id) {
    self::check_authorized();
    $item = Item::find($id);
    $itemauthors = Author::itemsAuthors($id);
    $authors = Author::all();
    View::make('item/edit.html', array('attributes' => $item, 'itemauthors' => $itemauthors, 'authors' => $authors));
  }

  // Aineiston muokkaaminen (lomakkeen käsittely)
  public static function update($id) {
    self::check_authorized();
    $params = $_POST;

    $attributes = array(
        'id' => $id,
        'title' => $params['title'],
        'itemtype' => $params['itemtype'],
        'otherdetails' => $params['otherdetails'],
        'authors' => array()
    );

    if (array_key_exists('authors', $params)) {
      $authors = $params['authors'];
      foreach ($authors as $author) {
        $attributes['authors'][] = $author;
      }
    }

    // Alustetaan Item-olio käyttäjän syöttämillä tiedoilla
    $item = new Item($attributes);
    $errors = $item->errors();

    if (count($errors) > 0) {
      $authors = Author::all();
      View::make('item/edit.html', array('errors' => $errors, 'attributes' => $attributes, 'authors' => $authors));
    } else {
      // Kutsutaan alustetun olion update-metodia, joka päivittää pelin tiedot tietokannassa
      $item->update();

      Redirect::to('/item/' . $item->id, array('message' => 'Aineistoa on muokattu onnistuneesti!'));
    }
  }

  // Aineiston poistaminen
  public static function destroy($id) {
    self::check_authorized();
    $item = new Item(array('id' => $id));
    $item->destroy();

    Redirect::to('/item', array('message' => 'Aineisto on poistettu onnistuneesti!'));
  }

}
