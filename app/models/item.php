<?php

class Item extends BaseModel {

  // Attribuutit
  public $id, $title, $itemtype, $added, $otherdetails, $authors, $status, $account, $account_id;

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

    # Tarkistetaan onko kohde lainassa
    $query2 = DB::connection()->prepare('SELECT item_id, Account.id, Account.email '
            . 'FROM Loan INNER JOIN Account ON Account.id = Loan.account_id '
            . 'WHERE item_id = :id AND checkedin IS NULL');
    $query2->execute(array('id' => $id));
    $row2 = $query2->fetch();
    $status = 0;
    $account = "";
    $account_id = 0;

    if ($row2) {
      $status = 1;
      $account = $row2['email'];
      $account_id = $row2['id'];
    } 

    if ($row) {
      $item = new Item(array(
          'id' => $row['id'],
          'title' => $row['title'],
          'itemtype' => $row['itemtype'],
          'added' => $row['added'],
          'otherdetails' => $row['otherdetails'],
          'status' => $status,
          'account' => $account,
          'account_id' => $account_id
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

    if ($this->authors != null) {
      $queryRow = 'INSERT INTO ItemAuthor (item_id, author_id) VALUES ';
      foreach ($this->authors as $author_id) {
        $queryRow .= '(\'' . $this->id . '\', \'' . $author_id . '\')';
        if ($author_id === end($this->authors)) {
          $queryRow .= ';';
        } else {
          $queryRow .= ', ';
        }
      }
      $query2 = DB::connection()->prepare($queryRow);
      $query2->execute();
    }
  }

  public function update() {
    $query = DB::connection()->prepare('UPDATE Item SET '
            . 'title = :title, '
            . 'itemtype = :itemtype, '
            . 'otherdetails = :otherdetails '
            . 'WHERE id = :id');
    $query->execute(array(
        'title' => $this->title,
        'itemtype' => $this->itemtype,
        'otherdetails' => $this->otherdetails,
        'id' => $this->id));

    $query2 = DB::connection()->prepare('DELETE FROM ItemAuthor WHERE item_id = :id');
    $query2->execute(array('id' => $this->id));

    if ($this->authors != null) {
      $queryRow = 'INSERT INTO ItemAuthor (item_id, author_id) VALUES ';
      foreach ($this->authors as $author_id) {
        $queryRow .= '(\'' . $this->id . '\', \'' . $author_id . '\')';
        if ($author_id === end($this->authors)) {
          $queryRow .= ';';
        } else {
          $queryRow .= ', ';
        }
      }
      $query3 = DB::connection()->prepare($queryRow);
      $query3->execute();
    }
  }

  public function destroy() {
    $query = DB::connection()->prepare('DELETE FROM ItemAuthor WHERE item_id = :id');
    $query->execute(array('id' => $this->id));
    $query2 = DB::connection()->prepare('DELETE FROM Item WHERE id = :id');
    $query2->execute(array('id' => $this->id));
  }

  public static function authorsItems($author_id) {
    $query = DB::connection()->prepare(
            'SELECT Item.id, Item.title
                FROM Author
                INNER JOIN ItemAuthor
                ON ItemAuthor.author_id = Author.id
                INNER JOIN Item
                ON Item.id = ItemAuthor.item_id
                WHERE Author.id =:author_id');
    $query->execute(array('author_id' => $author_id));
    $rows = $query->fetchAll();
    $items = array();

    foreach ($rows as $row) {
      $items[] = new Item(array(
          'id' => $row['id'],
          'title' => $row['title']
      ));
    }
    return $items;
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
