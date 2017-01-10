<?php

class Author extends BaseModel {

  public $id, $surname, $othernames;

  public function __construct($attributes) {
    parent::__construct($attributes);
//    $this->validators = array();
  }

  public static function find($id) {
    $query = DB::connection()->prepare('SELECT * FROM Author WHERE id = :id LIMIT 1');
    $query->execute(array('id' => $id));
    $row = $query->fetch();
    if ($row) {
      $author = new Author(array(
          'id' => $row['id'],
          'surname' => $row['surname'],
          'othernames' => $row['othernames']
      ));
      return $author;
    }
    return null;
  }
  
  public static function all() {
    // Alustetaan kysely tietokantayhteydellämme
    $query = DB::connection()->prepare('SELECT * FROM Author');
    // Suoritetaan kysely
    $query->execute();
    // Haetaan kyselyn tuottamat rivit
    $rows = $query->fetchAll();
    $authors= array();

    // Käydään kyselyn tuottamat rivit läpi
    foreach ($rows as $row) {
      $authors[] = new Author(array(
          'id' => $row['id'],
          'surname' => $row['surname'],
          'othernames' => $row['othernames']
      ));
    }

    return $authors;
  }

}
