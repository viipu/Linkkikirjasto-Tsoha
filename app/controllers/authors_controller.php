<?php

class AuthorController extends BaseController {

  public static function index() {
    $authors = Author::all();
    View::make('author/index.html', array('authors' => $authors));
  }

  public static function show($id) {
    $author = Author::find($id);
    $items = Item::authorsItems($id);
//    View::make('item/show.html', array('item' => $item, 'authors' => $authors));
      View::make('author/show.html', array('author' => $author, 'items' => $items));
  }

  public static function create() {
    self::check_authorized();
    View::make('author/new.html', array());
  }

  public static function store() {
    self::check_authorized();
    $params = $_POST;
    $attributes = array(
        'surname' => $params['surname'],
        'othernames' => $params['othernames']
    );

    $author = new Author($attributes);
    $errors = $author->errors();

    if (count($errors) == 0) {
      // Ei virheitä, kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
      $author->save();
      // Ohjataan käyttäjä lisäyksen jälkeen aineiston esittelysivulle
      Redirect::to('/author/' . $author->id, array('message' => 'Uusi tekijä on lisätty kirjastoon!'));
    } else {
      // uudessa aineistossa oli jotain vikaa, ohjataan takaisin lomakkeeseen
      View::make('author/new.html', array('errors' => $errors, 'attributes' => $attributes));
    }
  }

  // Aineiston muokkaaminen (lomakkeen esittäminen)
  public static function edit($id) {
    self::check_authorized();
    $author = Author::find($id);
    View::make('author/edit.html', array('attributes' => $author));
  }

  // Aineiston muokkaaminen (lomakkeen käsittely)
  public static function update($id) {
    ItemController::check_authorized();
    $params = $_POST;

    $attributes = array(
        'id' => $id,
        'surname' => $params['surname'],
        'othernames' => $params['othernames']
    );

    // Alustetaan Item-olio käyttäjän syöttämillä tiedoilla
    $author = new Author($attributes);
    $errors = $author->errors();

    if (count($errors) > 0) {
      View::make('author/edit.html', array('errors' => $errors, 'attributes' => $attributes));
    } else {
      // Kutsutaan alustetun olion update-metodia, joka päivittää pelin tiedot tietokannassa
      $author->update();

      Redirect::to('/author/' . $author->id, array('message' => 'Tekijää on muokattu onnistuneesti!'));
    }
  }

  // Aineiston poistaminen
  public static function destroy($id) {
    self::check_authorized();
    $author = new Author(array('id' => $id));
    $author->destroy();

    Redirect::to('/author', array('message' => 'Tekijä on poistettu onnistuneesti!'));
  }

}
