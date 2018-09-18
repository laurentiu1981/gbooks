<?php

namespace Models;


use Entities\TermEntity;

class TermModel extends BasicModel
{

  public function __construct()
  {
    parent::__construct();
  }

  function save($term)
  {
    if (is_null($term->getVid())) {
      $sql = 'SELECT vid FROM vocabulary WHERE vocabulary LIKE ?';
      $data = array($term->getVocabulary());
      $statement = $this->executeStatement($sql, $data);
      $term->setVid($statement->fetchObject()->vid);
    }
    $id = $term->getTid();
    if (isset($id)) {
      $sql = 'UPDATE terms SET vid=?, name=? WHERE id=?';
      $data = array($term->getVid(), $term->getName(), $id);
      $statement = $this->executeStatement($sql, $data);
    } else {
      $sql = 'INSERT INTO terms (vid, name) VALUES (?, ?)';
      $data = array($term->getVid(), $term->getName());
      $statement = $this->executeStatement($sql, $data);
    }
    return $statement;

  }

  /**
   * @param int $id
   *
   * @return TermEntity
   */
  function get($id)
  {
    $sql = 'SELECT id,vid,name FROM terms WHERE id=?';
    $data = array($id);
    $statement = $this->executeStatement($sql, $data);
    $row = $statement->fetchObject();
    $term = NULL;
    if ($row) {
      $term = new TermEntity(array(
        "tid" => $id,
        "vid" => $row->vid,
        "name" => $row->name,
      ));
    }
    return $term;
  }

  /**
   * @param string $vocabulary
   *    vocabulary name
   *
   * @param string $name
   *    term name
   *
   * @return TermEntity
   */
  function findByVocabularyAndName($vocabulary, $name)
  {
    $sql = 'SELECT T.id,T.vid,T.name,V.vocabulary 
            FROM terms AS T INNER JOIN vocabulary AS V ON T.vid=V.vid 
            WHERE V.vocabulary LIKE ? AND T.name LIKE ? ';
    $data = array($vocabulary, $name);
    $statement = $this->executeStatement($sql, $data);
    $row = $statement->fetchObject();
    $term = NULL;
    if ($row) {
      $term = new TermEntity(array(
        "tid" => $row->id,
        "vid" => $row->vid,
        "vocabulary" => $row->vocabulary,
        "name" => $row->name,
      ));
    }
    return $term;
  }
}