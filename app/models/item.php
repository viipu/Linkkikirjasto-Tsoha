<?php

class Item extends BaseModel {

  // Attribuutit
  public $id, $title, $itemtype, $added, $otherdetails;

  // Konstruktori
  public function __construct($attributes) {
    parent::__construct($attributes);
    $this->validators = array('validate_title', 'validate_itemtype');
  }

  public static function all() {
    // Alustetaan kysely tietokantayhteydellämme
    $query = DB::connection()->prepare('SELECT * FROM Item');
    // Suoritetaan kysely
    $query->execute();
    // Haetaan kyselyn tuottamat rivit
    $rows = $query->fetchAll();
    $items = array();

    // Käydään kyselyn tuottamat rivit läpi
    foreach ($rows as $row) {
      $items[] = new Item(array(
          'id' => $row['id'],
          'title' => $row['title'],
          'itemtype' => $row['itemtype'],
          'added' => $row['added'],
          'otherdetails' => $row['otherdetails']
      ));
    }

    return $items;
  }

  public static function find($id) {
    $query = DB::connection()->prepare('SELECT * FROM Item WHERE id = :id LIMIT 1');
    $query->execute(array('id' => $id));
    $row = $query->fetch();

    if ($row) {
      $item = new Item(array(
          'id' => $row['id'],
          'title' => $row['title'],
          'itemtype' => $row['itemtype'],
          'added' => $row['added'],
          'otherdetails' => $row['otherdetails']
      ));

      return $item;
    }

    return null;
  }

  public function save() {
    $query = DB::connection()->prepare('INSERT INTO Item (title, itemtype, otherdetails) VALUES (:title, :itemtype, :otherdetails) RETURNING id');
    $query->execute(array('title' => $this->title, 'itemtype' => $this->itemtype, 'otherdetails' => $this->otherdetails));

    $row = $query->fetch();

    $this->id = $row['id'];
  }

  public function update() {
    $query = DB::connection()->prepare('UPDATE Item SET '
            . 'title = :title, '
            . 'itemtype = :itemtype, '
            . 'otherdetails = :otherdetails '
            . 'WHERE id = :id');
    $query->execute(array('title' => $this->title, 'itemtype' => $this->itemtype, 'otherdetails' => $this->otherdetails));

//    $row = $query->fetch();
//
//    $this->id = $row['id'];
  }

  public function destroy() {
    $query = DB::connection()->prepare('DELETE FROM Item WHERE id = :id');
    $query->execute(array('id' => $this->id));
  }

  public function validate_title() {
    $errors = $this->{'validate_string_length'}($this->title, 1, 'Nimeke');
    return $errors;
  }

  public function validate_itemtype() {
    $errors = $this->{'validate_string_length'}($this->itemtype, 1, 'Tyyppi');
    return $errors;
  }

}
