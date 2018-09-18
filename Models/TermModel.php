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
    $sql = 'SELECT vid FROM vocabulary WHERE vocabulary LIKE ?';
    $data = array($term->getVocabulary());
    $statement = $this->executeStatement($sql, $data);
    $vocabularyId = $statement->fetchObject()->vid;

    $id = $term->getId();
    if (isset($id)) {
      $sql = 'UPDATE terms SET vid=?, name=? WHERE id=?';
      $data = array($vocabularyId, $term->getName(), $id);
      $statement = $this->executeStatement($sql, $data);
    } else {
      $sql = 'INSERT INTO terms (vid, name) VALUES (?, ?)';
      $data = array($vocabularyId, $term->getName());
      $statement = $this->executeStatement($sql, $data);
    }
    return $statement;

  }

  /**
   * @param $id
   * @return TermEntity
   */
  function get($id)
  {

    $sql = 'SELECT id,vid,name FROM terms WHERE id=?';
    $data = array($id);
    $statement = $this->executeStatement($sql, $data);
    $row = $statement->fetchObject();
    if ($row) {
      $term = new TermEntity(array(
        "id" => $id,
        "vocabulary" => $row->vid,
        "name" => $row->name,
      ));
    } else
      $term = new TermEntity(array());
    return $term;
  }

  /**
   * @param $name
   * @return TermEntity
   */
  function findByName($name)
  {
    $sql = 'SELECT id,vid,name FROM terms WHERE name LIKE ?';
    $data = array($name);
    $statement = $this->executeStatement($sql, $data);
    $row = $statement->fetchObject();
    if ($row) {
      $term = new TermEntity(array(
        "id" => $row->id,
        "vocabulary" => $row->vid,
        "name" => $row->name,
      ));
    } else
      $term = new TermEntity(array());
    return $term;
  }

  /**
   * @param $vocabulary
   * @return TermEntity
   */
  function findByVocabulary($vocabulary)
  {

    $sql = 'SELECT vid FROM vocabulary WHERE vocabulary LIKE ?';
    $data = array($vocabulary);
    $statement = $this->executeStatement($sql, $data);
    $vocabularyId = $statement->fetchObject()->vid;


    $sql = 'SELECT id,vid,name FROM terms WHERE vid LIKE ?';
    $data = array($vocabularyId);
    $statement = $this->executeStatement($sql, $data);
    $row = $statement->fetchObject();
    if ($row) {
      $term = new TermEntity(array(
        "id" => $row->id,
        "vocabulary" => $row->vid,
        "name" => $row->name,
      ));
    } else
      $term = new TermEntity(array());
    return $term;
  }
}