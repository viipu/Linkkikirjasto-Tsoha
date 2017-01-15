<?php

class Author extends BaseModel {

  public $id, $surname, $othernames;

  public function __construct($attributes) {
    parent::__construct($attributes);
    $this->validators = array();
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


  public function save() {
    $query = DB::connection()->prepare('INSERT INTO Author (surname, othernames) VALUES (:surname, :othernames) RETURNING id');
    $query->execute(array('surname' => $this->surname, 'othernames' => $this->othernames));
    $row = $query->fetch();
    $this->id = $row['id'];
  }

  public function update() {
    $query = DB::connection()->prepare('UPDATE Author SET '
            . 'surname = :surname, '
            . 'othernames = :othernames '
            . 'WHERE id = :id');
    $query->execute(array(
        'surname' => $this->surname,
        'othernames' => $this->othernames,
        'id' => $this->id));
  }

  public function destroy() {
    $query = DB::connection()->prepare('DELETE FROM ItemAuthor WHERE author_id = :id');
    $query->execute(array('id' => $this->id));
    $query2 = DB::connection()->prepare('DELETE FROM Author WHERE id = :id');
    $query2->execute(array('id' => $this->id));
  }
  
    public static function itemsAuthors($item_id) {
        $query = DB::connection()->prepare(
                'SELECT Author.id, Author.surname, Author.othernames
                FROM Item
                INNER JOIN ItemAuthor
                ON ItemAuthor.item_id = Item.id
                INNER JOIN Author
                ON Author.id = ItemAuthor.author_id
                WHERE Item.id =:item_id');
        $query->execute(array('item_id' => $item_id));
        $rows = $query->fetchAll();
        $authors = array();
        
        foreach ($rows as $row) {
            $authors[] = new Author(array(
                'id' => $row['id'],
                'surname' => $row['surname'],
                'othernames' => $row['othernames'],
            ));
        }
        return $authors;
    }
  
}
